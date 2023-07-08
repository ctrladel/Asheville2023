export default {
  $schema: 'https://git.drupalcode.org/project/sdc/-/raw/1.x/src/metadata.schema.json',
  machineName: 'preprocessExample',
  name: 'Preprocess example',
  status: 'stable',
  thirdPartySettings: {
    rjsf: {
      uiSchema: {},
      renderPreprocess: {
        number: {
          "$plugins":{
            "$plugin": "add_five"
          }
        }
      }
    }
  },
  props: {
    type: 'object',
    properties: {
      number: {
        title: 'Number',
        type: 'integer',
      },
    }
  },
};
