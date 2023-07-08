<?php

namespace Drupal\js_blocks\Plugin\Rjsf\RenderPreprocess;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelTrait;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rjsf\Plugin\RenderPreprocessPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @RjsfRenderPreprocess(
 *  id = "add_five",
 *  label = @Translation("Add five"),
 * )
 */
class AddFive extends RenderPreprocessPluginBase {

  public function preprocess($value, array $vars = [], array $schema = [], array $uiSchema = []) {
    return $value + 5;
  }

}
