<?php

namespace Drupal\radix_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Routing;

/**
 * Provides the form for adding messages.
 */
class ContactUsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'radix_contact_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['contact_us'] = [
      '#type' => 'markup',
      '#markup' => 'To avail our services, fill out the form below with your query and we will get back to you soon.',
     ];
    $form['fname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' =>  '',
    ];
    $form['mail'] = [
      '#type' => 'email',
      '#title' => $this->t('Your Email'),
      '#required' => TRUE,
      '#maxlength' => 50,
      '#default_value' =>  '',
    ];
	 /**$form['service_related'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Required Service'),
      '#required' => TRUE,
      '#maxlength' => 20,
      '#default_value' =>  '',
    ];*/
    $form['service_related'] = array(
        '#title' => t('Required Service'),
        '#type' => 'select',
        '#options' => array(t('--- SELECT ---'), t('Renewable Energy and Power'), t('Web and IT solutions'), t('Research and Others')),
      );
	$form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Your Requirements'),
      '#required' => TRUE,
      '#maxlength' => 255,
      '#default_value' => '',
    ];
	
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#button_type' => 'primary',
      '#default_value' => $this->t('Submit') ,
    ];
	
    return $form;

  }
  
   /**
   * {@inheritdoc}
   */
  public function validateForm(array & $form, FormStateInterface $form_state) {
       $field = $form_state->getValues();
	   
		$fields["fname"] = $field['fname'];
		if (!$form_state->getValue('fname') || empty($form_state->getValue('fname'))) {
            $form_state->setErrorByName('fname', $this->t('Name'));
        }
		
		
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array & $form, FormStateInterface $form_state) {
	try{
		$conn = Database::getConnection();
		
		$field = $form_state->getValues();
	   
		$fields["fname"] = $field['fname'];
    $ields["mail"] = $field['mail'];
		$fields["service_related"] = $field['service_related'];
		$fields["message"] = $field['message'];
		
		  $conn->insert('radix_contact')
			   ->fields($fields)->execute();
		  \Drupal::messenger()->addMessage($this->t('The data has been succesfully saved'));
		 
	} catch(Exception $ex){
		\Drupal::logger('radix_contact')->error($ex->getMessage());
	}
    
  }

}