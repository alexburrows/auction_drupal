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

    if (Bid::isBiddingOver() === FALSE) {
      if (!$top_bid) {
        return [
          '#markup' => t('There are no bids'),
        ];
      }
      elseif ($top_bid) {
        return [
          '#markup' => t('The current highest bid is %bid', array('%bid' => $top_bid)),
        ];
      }
    }
    else {
      return [
        '#markup' => t('Sorry bidding is now over'),
      ];
    }

  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }


}