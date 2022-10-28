<?php

/**
 * @File
 * Contains Drupal\radix_contact\Plugin\Block\ContactUsBlock.
 */

namespace Drupal\radix_contact\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Contact Us form inside a block.
 * 
 * @Block(
 *    id = "contact_us",
 *    admin_label = @Translation("Contact Us Block")
 * )
 */
class ContactUsBlock extends BlockBase {
    
    /**
     * {@inheritdoc}
     */
    public function build () {

        $form = \Drupal::formbuilder()-> getForm('Drupal\radix_contact\Form\ContactUsForm');
        return $form;
    }
}


