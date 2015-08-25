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
        message: 'Enter your theme\'s human readable name. (ie: Drupal Theme)'
      },
      {
        type: 'input',
        name: 'themeMachineName',
        message: 'Enter your theme\'s machine name. (ie: drupal_theme)'
      },
      {
        type: 'input',
        name: 'proxyAddress',
        message: 'Enter the website\'s local development url for browsersync. (ie: drupal-theme.dev)'
      }
    ];

    this.prompt(prompts, function (props) {
      this.props = props;
      done();
    }.bind(this));
  },

  writing: {
    app: function () {

      // Write theme.info
      this.fs.copyTpl(
        this.templatePath('theme.info'),
        this.destinationPath(this.props.themeMachineName + '/' + this.props.themeMachineName + '.info'),
        {
          themeHumanName: this.props.themeHumanName,
          themeMachineName: this.props.themeMachineName,
        }
      );

      // Write template.php
      this.fs.copyTpl(
        this.templatePath('template.php'),
        this.destinationPath(this.props.themeMachineName + '/' + 'template.php'),
        {
          themeMachineName: this.props.themeMachineName,
        }
      );

      // Write bower.json
      this.fs.copyTpl(
        this.templatePath('bower.json'),
        this.destinationPath(this.props.themeMachineName + '/' + 'bower.json'),
        {
          themeHumanName: this.props.themeHumanName,
          themeMachineName: this.props.themeMachineName,
        }
      );

      // Write package.json
      this.fs.copyTpl(
        this.templatePath('package.json'),
        this.destinationPath(this.props.themeMachineName + '/' + 'package.json'),
        {
          themeHumanName: this.props.themeHumanName,
          themeMachineName: this.props.themeMachineName,
        }
      );

      // Write gulpfile.js
      this.fs.copyTpl(
        this.templatePath('gulpfile.js'),
        this.destinationPath(this.props.themeMachineName + '/' + 'gulpfile.js'),
        {
          proxyAddress: this.props.proxyAddress,
        }
      );

      // Create build directory
      this.fs.copy(
        this.templatePath('build'),
        this.destinationPath(this.props.themeMachineName + '/' + 'build')
      );

      // Create dev directory
      this.fs.copy(
        this.templatePath('dev'),
        this.destinationPath(this.props.themeMachineName + '/' + 'dev')
      );

      // Create templates directory
      this.fs.copy(
        this.templatePath('templates'),
        this.destinationPath(this.props.themeMachineName + '/' + 'templates')
      );
    }
  },

  // Display completion message
  complete: function () {
    this.log('The BlueOI Drupal Theme Generator has finished building your new Drupal theme.');
  }
});
