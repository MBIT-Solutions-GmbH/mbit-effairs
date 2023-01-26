<?php
namespace MBIT\MbitEffairs\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use MBIT\MbitEffairs\Domain\Model\Subscriber;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Annotation\Validate;
use MBIT\MbitEffairs\Domain\Repository\SubscriberRepository;

/***
 *
 * This file is part of the "Effairs OptIn" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * SubscriberController
 */
class SubscriberController extends ActionController
{
    /**
     * FIX: No longer use of deprecated Annotation inject for $subscriberRepository,
     * instead added function injectSubscriberRepository().
     * Added use-Statement for MBIT\MbitEffairs\Domain\Repository\SubscriberRepository.
     */
    /**
     * subscriberRepository
     *
     * @var SubscriberRepository
     */
    protected $subscriberRepository;

    /**
     * Inject SubscriberRepository via Dependency Injection
     * 
     * @param SubscriberRepository $subscriberRepository
     */
    public function injectSubscriberRepository(SubscriberRepository $subscriberRepository) : void
    {
        $this->subscriberRespository = $subscriberRepository;
    }


    // Creates a Form for the User to sign up to the Newsletter 
    /**
     * action new
     *
     * @return void
     */
    public function newAction(): ResponseInterface
    {
        $salutations = array(
            0 => 'Herr',
            1 => 'Frau'
        );
        if ($this->request->hasArgument('checkedChannels')) {
            $checkedChannels = $this->request->getArgument('checkedChannels');
        }
        if (trim($this->settings['channels'])) {
            $channels = array();
            foreach (explode(PHP_EOL, trim($this->settings['channels'])) as $channel) {
                $temp = explode(':', $channel);
                if ($checkedChannels != null) {
                    if (in_array($temp[0], $checkedChannels)) {
                        $channels[] = array('key' => $temp[0], 'value' => $temp[1], 'checked' => '1');
                    } else {
                        $channels[] = array('key' => $temp[0], 'value' => $temp[1], 'checked' => '0');
                    }
                } else {
                    $channels[] = array('key' => $temp[0], 'value' => $temp[1], 'checked' => '0');
                }
            }
            if (count($channels) > 1) {
                $this->view->assign('channels', $channels);
            }
        }
        $this->view->assign('salutations', $salutations);
        if ($this->settings['Captcha'] == 1) {
            $this->view->assign('captcha', 1);
            $this->view->assign('sitekey', $this->settings['CaptchaSitekey']);
        }
        if ($this->request->hasArgument('newSubscriber')) {
            $this->view->assign('newSubscriber', $this->request->getArgument('newSubscriber'));
        }
        return $this->htmlResponse();
    }


    // Adds a new Contact to the subscriber List and prompts the backend to send a confirmation email 
    /**
     * FIX: No longer use of deprecated Annotation validate,
     * instead used Validate from TYPO3\CMS\Extbase\Annotation\Validate for createAction().
     * Added use-Statement for Validate.
     */
    /**
     * action create
     *
     * @param \MBIT\MbitEffairs\Domain\Model\Subscriber $newSubscriber
     * @Validate("MBIT\MbitEffairs\Validator\HoneypotValidator", param="newSubscriber")
     *
     */
    /**
     * action create
     *
     * @param Subscriber $newSubscriber
     * @Validate("MBIT\MbitEffairs\Validator\HoneypotValidator", param="newSubscriber")
     * @return void
     */
    public function createAction(Subscriber $newSubscriber)
    {
        $channelString = '';
        //		if (count(explode(PHP_EOL, trim($this->settings['channels']))) > 1) {
        //			if ($this->request->hasArgument('channel')) {
        //				$checkedChannels = array();
        //				$channels = $this->request->getArgument('channel');
        //				$channelString = "";
        //				foreach ($channels as $key => $value) {
        //					if ($value != "") {
        //						$channelString .= $value . ":";
        //					}
        //					$checkedChannels[] = $value;
        //				}
        //				$channelString = rtrim($channelString, ":");
        //			}
        //		} else if (count(explode(PHP_EOL, trim($this->settings['channels']))) == 1) {
        //			$channelString = explode(':', trim($this->settings['channels']))[0];
        //		}

        $postData = array(
            "Tracking" => ($newSubscriber->getTracking() ? '1' : '0'),
            'Salutation' => $newSubscriber->getSalutation() == 0 ? 'Herr' : 'Frau',
            'Title1' => $newSubscriber->getTitle(),
            'Firstname' => $newSubscriber->getFirstname(),
            'Lastname' => $newSubscriber->getLastname(),
            'Middlename' => '',
            'Company' => $newSubscriber->getCompany(),
            'Street' => $newSubscriber->getStreet(),
            'Streetnumber' => '',
            'Postcode' => $newSubscriber->getPostcode(),
            'City' => $newSubscriber->getCity(),
            'Country' => $newSubscriber->getCountry(),
            'Email' => $newSubscriber->getEmail(),
            'Phone' => $newSubscriber->getPhone(),
            'Mobile' => $newSubscriber->getMobile(),
            'Fax' => $newSubscriber->getFax(),
            'Source' => $this->settings['ClientSource'],
            'Channels' => $channelString,
            'TenantId' => $this->settings['TenantId']
        );
        $body = json_encode($postData);
        $authHeader = $this->buildAuthHeader($this->settings['AppKey'], $this->settings['AppSecret'], $this->settings['TenantId'], $this->settings['ApiURLOptin'], 'POST', $body);
        $curl = curl_init($this->settings['ApiURLOptin']);
        $headers = array(
            'Accept: application/json; charset=utf-8',
            'Content-Type: application/json; charset=utf-8',
            'Authorization: ' . $authHeader
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, 'MBIT PHP RestClient/1.0');
        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response, TRUE);
        if (!empty($response) && $responseData['errorcode'] == 0) {
            $uri = $this->uriBuilder->reset()->setTargetPageUid($this->settings['OptinPageId'])->build();
            $this->redirectToUri($uri);
        } else {
            $this->addFlashMessage('Es ist ein Fehler aufgetreten.', '', AbstractMessage::ERROR);
            return (new ForwardResponse('new'))->withControllerName('Subscriber')->withExtensionName('MbitEffairs')->withArguments(array('newSubscriber' => $newSubscriber));
        }
    }


    /**
     * action unsubscribe
     *
     * @return void
     */
    public function unsubscribeAction(): ResponseInterface
    {
        if ($this->request->hasArgument('email')) {
            $this->view->assign('email', $this->request->getArgument('email'));
        }
        return $this->htmlResponse();
    }


    // Removes a Contact from the subscriber List and prompts the backend to send a confirmation email 
    /**
     * action delete
     *
     * @param string $email
     *
     */
    public function deleteAction($email)
    {
        $postData = array(
            'Email' => $email,
            'Source' => $this->settings['ClientSource'],
            'TenantId' => $this->settings['TenantId']
        );
        $body = json_encode($postData);
        $authHeader = $this->buildAuthHeader($this->settings['AppKey'], $this->settings['AppSecret'], $this->settings['TenantId'], $this->settings['ApiURLOptout'], 'POST', $body);
        $curl = curl_init($this->settings['ApiURLOptout']);
        $headers = array(
            'Accept: application/json; charset=utf-8',
            'Content-Type: application/json; charset=utf-8',
            'Authorization: ' . $authHeader
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, 'MBIT PHP RestClient/1.0');
        $response = curl_exec($curl);
        curl_close($curl);
        // Decode the response
        $responseData = json_decode($response, TRUE);
        if ($responseData['errorCode'] == -300) {
            $this->addFlashMessage(LocalizationUtility::translate('tx_mbiteffairs_domain_model_subscriber.unsubscribenotfound', 'mbit_effairs'), '', AbstractMessage::ERROR);
            return (new ForwardResponse('unsubscribe'))->withControllerName('Subscriber')->withExtensionName('MbitEffairs')->withArguments(array('email' => $email));
        }
        $uri = $this->uriBuilder->reset()->setTargetPageUid($this->settings['UnsubscribePageId'])->build();
        $this->redirectToUri($uri);
    }


    // Creates a hash from TenantId, AppKey & AppSecret to identify yourself to the backend  
    /**
     * @param $appId
     * @param $appSecret
     * @param $tenantId
     * @param $requestUrl
     * @param $requestMethod
     * @param $body
     */
    function buildAuthHeader($appId, $appSecret, $tenantId, $requestUrl, $requestMethod, $body = null)
    {
        $nonce = uniqid();
        $timestamp = time();
        $contentBase64 = '';
        if ($body != null) {
            $hash = strtoupper(md5($body));
            $contentBase64 = base64_encode($hash);
        }
        $signatureRaw = $appId . $tenantId . strtolower(urlencode($requestUrl)) . $requestMethod . $timestamp . $nonce . $contentBase64;
        $signature = hash_hmac('sha256', $signatureRaw, base64_decode($appSecret));
        $signatureBase64 = base64_encode(strtoupper($signature));
        return 'hmac ' . $appId . ':' . $tenantId . ':' . $nonce . ':' . $timestamp . ':' . $signatureBase64;
    }

    /**
     * A template method for displaying custom error flash messages, or to
     * display no flash message at all on errors. Override this to customize
     * the flash message in your action controller.
     *
     * @api
     * @return string|boolean The flash message or FALSE if no flash message should be set
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }

}
