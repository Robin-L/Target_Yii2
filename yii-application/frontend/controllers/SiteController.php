<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\MailCall;
/**
 * Site controller
 */
class SiteController extends Controller
{
    private $attributes = [];
    private $username;
    private $source;
    private $socialUser;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['captcha'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin($viaSocial = false)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($viaSocial) {
            Yii::$app->user->login($this->socialUser);
        } else {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            } else {
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup($viaSocial = false)
    {
        if ($viaSocial) {
            if ($this->emailPresent() && $this->emailAlreadyInUse()) {
                return Yii::$app->getSession()->setFlash('error', [Yii::t('app', "User with the same email as in {source} account already exists but isn't synced. Login with username and password and click the {source} sync link to sync accounts.", ['source' => $this->source]),
                    ]);
            } else {
                $user = $this->createUser();
                $transaction = $user->getDb()->beginTransaction();
                if ($user->save()) {
                    $auth = $this->createAuth($user);
                    if ($auth->save()) {
                        $transaction->commit();
                        Yii::$app->user->login($user);
                        MailCall::onMailableAction('signup', 'site');
                    } else {
                        return Yii::$app->getSession()->setFlash('error', [Yii::t('app', "We were unable to complete the process and sync {source}.", ['source' => $this->source]),
                            ]);
                    }
                } else {
                    if (User::find()->where(['username' => $this->username])) {
                        return Yii::$app->getSession()->setFlash('error', [Yii::t('app', "Username already taken, please signup through the site Signup form and use a different username, Thanks."),
                            ]);
                    } else {
                        return Yii::$app->getSession()->setFlash('error', [Yii::t('app', "We were unable to complete the process and sync {source}.", ['source' => $this->source]),
                            ]);
                    }
                }
            }
        } else {
            $model = new SignupForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        MailCall::onMailableAction('signup', 'site');
                        
                        return $this->goHome();
                    }
                }
            }

            return $this->render('signup', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function onAuthSuccess($client)
    {
        $this->attributes = $client->getUserAttributes();

        $this->source = $client->getId();

        $this->formatProviderResponse($this->source);

        if (!$this->emailPresent()) {
            return Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', "unable to finish, {client} did not provide us with an email. Please check your settings on {client}.", ['client' => $client->getTitle()]),
            ]);
        }

        $existingAuth = $this->findExistingAuth();

        if (Yii::$app->user->isGuest) {
            if ($existingAuth) {
                $this->socialUser = $existingAuth->user;
                $viaSocial = true;
                $this->actionLogin($viaSocial);
            } else {
                $viaSocial = true;
                $this->actionSignup($viaSocial);
            }
        } else {
            if (!$existingAuth && $this->matchEmail()) {
                $auth = $this->createAuth(Yii::$app->user);
                $auth->save();
                Yii::$app->getSession()->setFlash('success', [Yii::t('app', "Your {source} account is successfully synced.", ['source' => $this->source]),
                    ]);
            } else {
                if (!$this->matchEmail()) {
                    Yii::$app->getSession()->setFlash('error', [Yii::t('app', "Your {source} account could not be synced.", ['source' => $this->source]),
                    ]);
                }
            }
        }


        /*$auth = Auth::find()->where(['source' => $this->source, 'source_id' => $this->attributes['id'],])->one();
        if (Yii::$app->user->isGuest) {
            if ($auth) {
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else {
                if (isset($this->attributes['email']) && User::find()->where(['email' => $this->attributes['email']])->exists()) {
                    return Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', "User with the same email as in {client} account already exists but isn't synced. Login with username and password and click the {client} sync link to sync accounts.", ['client' => $client->getTitle()]),
                        ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                            'username'  => $this->attributes[$this->username],
                            'email'     => $this->attributes['email'],
                            'password'  => $password,
                        ]);
                    $user->generateAuthKey();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new Auth([
                                'user_id'   => $user->id,
                                'source'    => $client->getId(),
                                'source_id' => (string)$this->attributes['id'],
                            ]);

                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                            MailCall::onMailableAction('signup', 'site');
                        } else {
                            return Yii::$app->getSession()->setFlash('error', [Yii::t('app', "We were unable to complete the process and sync {client}.", ['client' => $client->getTitle()]),
                                ]);
                        }
                    } else {
                        return Yii::$app->getSession()->setFlash('error', [Yii::t('app', "We were unable to complete the process and sync {client}.",['client' => $client->getTitle()]),
                            ]);
                    }
                }
            }
        } else {
            if (!$auth && $this->attributes['email'] == Yii::$app->user->identity->email) {
                $auth = new Auth([
                        'user_id' => Yii::$app->user->id,
                        'source'  => $this->source,
                        'source_id' => (string)$this->attributes['id'],
                    ]);
                $auth->save();
                Yii::$app->getSession()->setFlash('success', [Yii::t('app', "Your {client} account is successfully synced.", ['client' => $client->getTitle()]),
                    ]);
            } else {
                if ($this->attributes['email'] != Yii::$app->user->identity->email) {
                    Yii::$app->getSession()->setFlash('error', [Yii::t('app', "Your {client} account could not be synced.", ['client' => $client->getTitle()]),
                        ]);
                } else {
                    Yii::$app->getSession()->setFlash('success', [Yii::t('app', "Your {client} account is already synced.", ['client' => $client->getTitle()]),
                        ]);
                }
            }
        }*/
    }

    private function createUser()
    {
        $password = Yii::$app->security->generateRandomString(6);
        $user = new User([
                'username' => $this->attributes[$this->username],
                'email' => $this->attributes['email'],
                'password' => $password,
            ]);
        $user->generateAuthKey();
        return $user;
    }

    private function createAuth($user)
    {
        $auth = new Auth([
                'user_id' => $user->id,
                'source' => $this->source,
                'source_id' => (string)$this->attributes['id'],
            ]);
        return $auth;
    }

    private function findExistingAuth()
    {
        $auth = Auth::find()->where([
                'source' => $this->source,
                'source_id' => $this->attributes['id'],
            ])->one();
        return $auth;
    }

    private function emailPresent()
    {
        return isset($this->attributes['email']) ? true : false;
    }

    private function matchEmail()
    {
        return $this->attributes['email'] == Yii::$app->user->identity->email ? true : false;
    }

    private function formatProviderResponse($source)
    {
        switch ($source) {
            case 'facebook':
                $this->username = 'name';
                break;
            case 'github': 
                $this->username = 'login';
                break;
            case 'twitter':
                $this->username = 'fullName';
                $fullName = $this->attributes['first_name'].' '.$this->attributes['last_name'];
                $this->attributes['fullName'] = $fullName;
                break;
            case 'google':
                $this->username = 'displayName';
                $emails = $this->attributes['emails'];
                foreach ($emails as $email) {
                    foreach ($email as $k => $v) {
                        if ($k == 'value') {
                            $this->attributes['email'] = $v;
                        }
                    }
                }
                break;
            default:
                $this->username = 'name';
                break;
        }
    }

    private function emailAlreadyInUse()
    {
        return User::find()->where(['email' => $this->attributes['email']])->exists() ? true : false;
    }
}
