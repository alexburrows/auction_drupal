<?php

namespace Drupal\auction\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\auction\Bid;

/**
 * @Block(
 *   id = "current_bids",
 *   admin_label = @Translation("Current bids"),
 *   category = @Translation("Custom")
 * )
 */
class CurrentBids extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $top_bid = Bid::lastBid();

    if (Bid::isBiddingOver()) {
      return [
        '#markup' => t('The winning bid is %bid', array('%bid' => $top_bid)),
      ];
    }
    else {
      return [
        '#markup' => t('The current highest bid is %bid', array('%bid' => $top_bid)),
      ];
    }

  }


}