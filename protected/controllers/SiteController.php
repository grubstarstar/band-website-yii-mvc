<?php

Yii::import('application.lib.RUtils.RMailer');

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Deals with subscibers to the newsletter
	 */
	public function actionSubscribe()
	{
		$response = '';

		if(Yii::app()->request->isAjaxRequest)
		{
			try
			{
				// add to subscribers list.
				$model = new MailingList();
				$model->attributes = $_POST['MailingList'];
				if($model->save())
				{
					// send email welcoming them to the list
					$mailer = new RMailer();

					$mailer->from = array();

					$mailer->to = array(
						array($model->email => $model->name),
					);

					// $mailer->cc = array();

					// $mailer->bcc = array();

					$mailer->subject = "Thank you for subscribing!";
					$mailer->html = "<h1>This is an email</h1><p>This is a paragrapha</p>";
					$mailer->text = "This is an email\n\nThis is a paragrapha";

					if($mailer->send())
					{
						Yii::log("Successfully sent email", "RMailer");
					}
					else
					{
						Yii::log($mailer->ErrorMessage, "RMailer");
					}

					$response = "<p>Thank you for subscribing</p>";
				}
				else
				{
					$response = "<p>Sorry, please try again later</p>";
				}
			}
			catch(Exception $ex)
			{
				Yii::log($ex->message, "RMailer");
				$response = "<p>Sorry, please try again later</p>";
			}

		}
		
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$mailer = new RMailer();

		$mailer->from = array( Yii::app()->params['adminEmail'] => Yii::app()->params['adminName'] );

		$mailer->to = array(
			array('userb@richtest.com' => 'Sender Smith B'),
			array('usera@richtest.com' => 'Sender Smith A'),
		);

		$mailer->cc = array(
			array('userc@richtest.com' => 'Sender Smith 5'),
			array('userd@richtest.com' => 'Sender Smith 6'),
		);

		$mailer->bcc = array(
			array('usere@richtest.com' => 'Sender Smit 2345'),
		);

		$mailer->subject = "Blah Blah";
		$mailer->html = "<h1>This is an email</h1><p>This is a paragrapha</p>";
		$mailer->text = "This is an email\n\nThis is a paragrapha";

		if(!$mailer->send())
		{
			Yii::log($mailer->ErrorMessage);
		}
		else
		{
			Yii::log("Success");
		}



		// $model=new ContactForm;
		// if(isset($_POST['ContactForm']))
		// {
		// 	$model->attributes=$_POST['ContactForm'];
		// 	if($model->validate())
		// 	{
		// 		$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
		// 		$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
		// 		$headers="From: $name <{$model->email}>\r\n".
		// 			"Reply-To: {$model->email}\r\n".
		// 			"MIME-Version: 1.0\r\n".
		// 			"Content-type: text/plain; charset=UTF-8";

		// 		mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
		// 		Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
		// 		$this->refresh();
		// 	}
		// }
		// $this->render('contact',array('model'=>$model));

		// validate the email

		// write the email to the mailing list table, along with name

		// send an email introducing them, option to unsubscribe.
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}