<?php
/**
 * Created by PhpStorm.
 * User: alexburrows
 * Date: 20/05/2017
 * Time: 13:36
 */

namespace Drupal\auction\Plugin\Block;


use Drupal\Core\Annotation\Translation;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\Entity;
use Drupal\commerce_product\Entity\Product;
use Drupal\auction\Bid;

/**
 * Class AuctionCountdown
 * @package Drupal\auction\Plugin\Block
 *
 * @Block(
 *  id = "auction_countdown",
 *  admin_label = @Translation("Auction countdown"),
 *  category = @Translation("Auction")
 * )
 */
class AuctionCountdown extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Product id.
    $product_id = \Drupal::routeMatch()->getParameter('commerce_product')->id();
    $auction = \Drupal::entityTypeManager()->getStorage('commerce_product')->load($product_id);
    $end_date = strtotime($auction->get('field_end_auction_on')->value);

    $time = \Drupal::service('date.formatter')->formatDiff(time(), $end_date);

    if (Bid::isBiddingOver()) {
      return [
        '#markup' => t('Bidding is over', 'warning')
      ];
    }
    else {
      return[
        '#theme' => 'auction_countdown',
        '#time' => $time,
      ];
    }

  }


}