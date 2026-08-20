const path = require( 'path' );

module.exports = {
  mode: 'production',
  entry: {
    admin: './src/js/admin/manager.js',
    wab: './src/js/frontend/manager.js'
  },
  output: {
    filename: '[name].js',
    path: path.resolve( __dirname, 'js' )
  },
};
