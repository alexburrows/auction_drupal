<?php

namespace Drupal\auction;

/**
 * Bid builder.
 * @package Drupal\auction
 */
class Bid {

  /**
   * Display latest bid.
   */
  public static function lastBid() {
    $product_id = \Drupal::routeMatch()->getParameter('commerce_product')->id();
    $auction = \Drupal::entityTypeManager()->getStorage('commerce_product')->load($product_id);
    $bids = $auction->get('field_bids')->getValue();
    $bid_ids = array();
    foreach ($bids as $bid) {
      $bid_ids[] = $bid['target_id'];
    }

    $query = \Drupal::database()->select('auction_bid', 'a')
      ->fields('a', array('bid_amount'))
      ->condition('etid', $product_id, 'IN')
      ->orderBy('bid_amount', DESC)
      ->range(0, 1)
      ->execute();
    $result = $query->fetchField();

    return $result;
  }

  /**
   * Determine if bidding has finished.
   */
  public static function isBiddingOver() {
    $product_id = \Drupal::routeMatch()->getParameter('commerce_product')->id();
    $auction = \Drupal::entityTypeManager()->getStorage('commerce_product')->load($product_id);
    $end_date = strtotime($auction->get('field_end_auction_on')->value);

    if (time() >= $end_date) {
      return TRUE;
    }
  }

  /**
   * Show the winning bid.
   */
  public static function showWinningBid() {
    if (self::isBiddingOver()) {
      return t('The winning bid is %bid', array('%bid' => self::lastBid()));
    }
  }

}