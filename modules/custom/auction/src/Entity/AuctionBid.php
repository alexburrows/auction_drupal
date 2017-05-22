<?php

namespace Drupal\auction\Entity;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\Annotation\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Auction Bid entity.
 *
 * @ingroup auction_bid
 *
 * @ContentEntityType(
 *   id = "auction_bid",
 *   label = @Translation("Auction Bid"),
 *   base_table = "auction_bid",
 *   entity_keys = {
 *    "id" = "id",
 *    "uuid" = "uuid",
 *    "bid_amount" = "bid_amount"
 *   },
 * )
 *
 */
class AuctionBid extends ContentEntityBase implements ContentEntityInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the bid entity'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID for the bid entity'))
      ->setReadOnly(TRUE);

    // Change to a int.
    $fields['etid'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Entity ID'))
      ->setDescription(t('Entity bid belongs to.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => '255'
      ));

    // Change to a int.
    $fields['uid'] = BaseFieldDefinition::create('string')
      ->setLabel(t('User ID'))
      ->setDescription(t('Bid user belongs to.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => '255'
      ));

    $fields['bid_amount'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Bid amount'))
      ->setDescription(t('Bid user belongs to.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => '255'
      ));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time when the profile was last edited.'))
      ->setRevisionable(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time when the bid was created.'));

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDescription(t('Whether the bid is active.'))
      ->setDefaultValue(TRUE)
      ->setRevisionable(TRUE);

    return $fields;
  }

}