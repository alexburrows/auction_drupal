<?php

namespace Drupal\auction\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\auction\Bid;

/**
 * @Block(
 *   id = "bidding_form",
 *   admin_label = @Translation("Bidding form block"),
 *   category = @Translation("Custom")
 * )
 */
class BiddingBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    if (Bid::isBiddingOver() == FALSE) {
      $form = \Drupal::formBuilder()->getForm('\Drupal\auction\Form\BiddingForm');

      return $form;
    }
  }


}