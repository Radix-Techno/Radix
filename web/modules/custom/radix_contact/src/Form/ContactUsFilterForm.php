<?php
namespace Drupal\radix_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Routing;

/**
 * Provides the form for filter contact messages.
 */
class ContactUsFilterForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ContactUsFilterForm_filter_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
   

    $form['filters'] = [
        '#type'  => 'fieldset',
        '#title' => $this->t('Filter'),
        '#open'  => true,
    ];

    $form['filters']['fname'] = [
        '#title'         => 'Name',
        '#type'          => 'search'
		
    ];
    $form['filters']['actions'] = [
        '#type'       => 'actions'
    ];

    $form['filters']['actions']['submit'] = [
        '#type'  => 'submit',
        '#value' => $this->t('Filter')
		
    ];
   
    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
     
	 if ( $form_state->getValue('fname') == "") {
		$form_state->setErrorByName('from', $this->t('You must enter a valid full name.'));
     }
   }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array & $form, FormStateInterface $form_state) {	  
	  $field = $form_state->getValues();
	  $fname = $field["fname"];
    $url = \Drupal\Core\Url::fromRoute('radix_contact.radix_contact')
          ->setRouteParameters(array('fname'=>$fname));
    $form_state->setRedirectUrl($url); 
  }

}