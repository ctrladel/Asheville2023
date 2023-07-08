import headingComponent from "../heading/heading.component.js";
import textComponent from "../text/text.component.js";
import buttonComponent from "../button/button.component.js";

const ctaProps = {...buttonComponent.props};
ctaProps.properties.treatment.default = 'fill';
ctaProps.properties.variant.default = 'accent';
ctaProps.properties.size.default = 'l';
ctaProps.properties.icon.properties.size.default = 'l';

export default {
  $schema: 'https://git.drupalcode.org/project/sdc/-/raw/1.x/src/metadata.schema.json',
  machineName: 'ctaBanner',
  name: 'CTA Banner',
  status: 'stable',
  thirdPartySettings: {
    rjsf: {
      uiSchema: {
        'ui:title': 'CTA Banner',
        background: {
          'ui:widget': 'color_picker',
          "ui:colorProps":{
            'orange': {
              'hex': '#f26522'
            },
            'blue': {
              'hex': '#024d69'
            },
            'grey': {
              'hex': '#eee'
            },
            'brown': {
              'hex': '#886454'
            },
          }
        },
        heading: headingComponent.thirdPartySettings.rjsf.uiSchema,
        text: textComponent.thirdPartySettings.rjsf.uiSchema,
        cta: buttonComponent.thirdPartySettings.rjsf.uiSchema,
      }
    }
  },
  props: {
    type: 'object',
    properties: {
      background: {
        type: 'string',
        title: 'Background Color',
        enum: [
          'orange',
          'blue',
          'grey',
          'brown'
        ],
        enumNames: [
          'Orange',
          'Blue',
          'Grey',
          'Brown'
        ],
      },
      heading: headingComponent.props,
      text: textComponent.props,
      cta: ctaProps,
    }
  },
};
