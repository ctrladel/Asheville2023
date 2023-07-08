<?php

namespace Drupal\js_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Create a SDC JS Block.
 *
 * @Block(
 *  id = "json_block",
 *  admin_label = @Translation("SDC Block"),
 *  category = @Translation("SDC Blocks"),
 *  deriver = "Drupal\js_blocks\Plugin\Derivative\SdcBlockDeriver"
 * )
 */
class SdcBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'values' => '{}',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $values = $this->configuration['values'] ?? '{}';
    $values = json_decode($values);

    $processed = \Drupal::getContainer()->get('rjsf.render.preprocessor')->preprocess(
      $values,
      $this->pluginDefinition['definition']['thirdPartySettings']['rjsf']['renderPreprocess'] ?? [],
      $this->pluginDefinition['definition']['props'],
      $this->pluginDefinition['definition']['thirdPartySettings']['rjsf']['uiSchema'] ?? [],
    );

    $processed['processed']['original'] = $values;

    $component = [
      '#type' => 'component',
      '#component' => $this->getPluginDefinition()['definition']['id'],
      '#props' => json_decode(json_encode($processed['processed']), TRUE),
      '#slots' => [],
    ];

    $processed['cacheable_metadata']->applyto($component);

    return $component;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form += parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();
    $plugin = $this->getPluginDefinition();

    $component = $plugin['definition'];
    $schema = [
      'schema' => $component['props'],
      'uiSchema' => $component['thirdPartySettings']['rjsf']['uiSchema'] ?? [],
    ];
    $form_state->set('component', $schema);

    $values = $config['values'] ?? '{}';
    $values = json_decode($values);

    $form['rjsf_element'] = [
      '#type' => 'rjsf_editor',
      '#schema' => $component['props'],
      '#uiSchema' => $component['thirdPartySettings']['rjsf']['uiSchema'] ?? [],
      '#default_value' => $values ?? $this->defaultConfiguration()['values'],
      '#client_validation' => TRUE,
    ];

    return $form;
  }

  /**
   * Handles decoding the component data and saving it to the block.
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Decode the value while respecting the difference between objects and
    // arrays. This is particularly important when value contains an empty json
    // object {} because Json::decode or json_decode($var, TRUE) will convert
    // {} to an empty array which can cause type checking during schema
    // validation to fail.
    $this->configuration['values'] = $form_state->getValue(['rjsf_element', 'value']);

    parent::blockSubmit($form, $form_state);
  }

}
