<?php

namespace Drupal\auction\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\Entity;
use Drupal\auction\Bid;

/**
 * Generates a form that allows bidding.
 *
 * Class BiddingForm
 * @package Drupal\auction\Form
 */
class BiddingForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bidding_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $user = \Drupal::currentUser()->id();

    $form['bid'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Bidding form'),
    ];
    $form['bid']['bid_amount'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Bid amount'),
      '#length' => '10',
      '#required' => TRUE,
    ];
    $form['bid']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add Bid')
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $new_bid = $form_state->getValue('bid_amount');
    $top_bid = Bid::lastBid();
    if ($new_bid <= $top_bid) {
      // Set an error for the form element with a key of "title".
      $form_state->setErrorByName('bid_amount', $this->t('You must bid higher than %bid_amount', array(
        '%bid_amount' => $new_bid,
      )));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $new_bid = $form_state->getValue('bid_amount');
    $product_id = \Drupal::routeMatch()->getParameter('commerce_product')->id();

    $data = array(
      'type' => 'auction_bid',
      'bid_amount' => $new_bid,
      'etid' => $product_id,
      'uid' => \Drupal::currentUser()->id(),
      'status' => 1,
    );
    $entity = \Drupal::entityTypeManager()
      ->getStorage('auction_bid')
      ->create($data);
    $entity->save();
    $bid_id = $entity->id();


    $product_id = \Drupal::routeMatch()->getParameter('commerce_product')->id();

    $auction = \Drupal::entityTypeManager()
      ->getStorage('commerce_product')
      ->load($product_id);
    $auction->field_bids[] = ['target_id' => $bid_id];
    $auction->save();


  }


}