'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');

module.exports = yeoman.generators.Base.extend({
  prompting: function () {
    var done = this.async();

    // Have Yeoman greet the user.
    this.log(yosay(
      'Welcome to the ' + chalk.red('BlueOI Drupal Theme') + ' generator!'
    ));

    // Set variables
    var prompts = [
      {
        type: 'input',
        name: 'themeHumanName',
        message: 'Enter your theme\'s human readable name.',
        default: 'Drupal Theme'
      },
      {
        type: 'input',
        name: 'themeMachineName',
        message: 'Enter your theme\'s machine name.',
        default: 'drupal_theme'
      },
      {
        type: 'input',
        name: 'proxyAddress',
        message: 'Enter your website\'s development url for browsersync.',
        default: 'drupal.boi'
      }
    ];

    this.prompt(prompts, function (props) {
      this.props = props;
      done();
    }.bind(this));
  },

  writing: {
    app: function () {

      // Build drupal theme from templates
      this.fs.copyTpl(
          this.templatePath('**'),
          this.destinationPath(this.props.themeMachineName + '/'),
          {
            themeHumanName: this.props.themeHumanName,
            themeMachineName: this.props.themeMachineName,
            proxyAddress: this.props.proxyAddress
          }
      );

      // Rename drupal theme info file
      this.fs.move(
          this.destinationPath(this.props.themeMachineName + '/' + 'theme.info'),
          this.destinationPath(this.props.themeMachineName + '/' + this.props.themeMachineName + '.info'),
          {
            themeMachineName: this.props.themeMachineName
          }
      );

    }
  },

  // Display completion message
  complete: function () {
    this.log('The BlueOI Drupal Theme Generator has finished building your new Drupal theme.');
  }
});
