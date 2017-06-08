var aglio = require('aglio');

// Render a blueprint with a template by name
// themeStyle: 'customize/style.less'
var options = {
  themeVariables: 'flatly',
  themeFullWidth: true,
  locals: {
    livePreview: true
  }
};

aglio.renderFile('index.apib', '../public/index.html', options, function (err, warnings) {
    if (err) console.log(err);
    if (warnings) console.log(warnings);
});