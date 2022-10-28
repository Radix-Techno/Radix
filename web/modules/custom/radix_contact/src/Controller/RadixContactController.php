<?php
namespace Drupal\radix_contact\Controller;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Routing;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RadixContactController.
 *
 * @package Drupal\radix_contact\Controller
 */
class RadixContactController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function listcontactmessages() {
	//Get parameter value while submitting filter form  
	$fname = \Drupal::request()->query->get('fname');
	//$marks = \Drupal::request()->query->get('marks');
	
	//====load filter controller
	$form['form'] = $this->formBuilder()->getForm('Drupal\radix_contact\Form\ContactUsfilterForm');

    // Create table header.
    $header = [
      'id' => $this->t('Id'),
      'fname' => $this->t('Name'),
	    'service_related' => $this->t('Service Required'),
	    'message'=> $this->t('message'),	  
	    'opt' =>$this->t('Operations')
    ];

    $form['radix_contact'] = [
      '#title' => $this->t('Add'),
      '#type' => 'link',
      '#url' => Url::fromRoute('radix_contact.contactus'),
    ];

    $form['show'] = [
      '#title' => $this->t('List'),
      '#type' => 'link',
      '#url' => Url::fromRoute('radix_contact.radix_contact'),
    ];
	
	
   if($fname == "" && $marks ==""){
    $form['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => get_contactus("All","",""),
      '#empty' => $this->t('No records found'),
    ];
   }else{
	    $form['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => get_contactus("",$fname),
      '#empty' => $this->t('No records found'),
    ];
   }
    $form['pager'] = [
      '#type' => 'pager'
    ];
    return $form;
  }


  /**
   * {@inheritdoc}
   * Deletes the given data
   */
  public function deleteContactMessage($cid) {
     $res = db_query("delete from radix_contact where id = :id", array(':id' => $cid));
    drupal_set_message('Details deleted');
    return $this->redirect('radix_contact.radix_contact');

  }
}