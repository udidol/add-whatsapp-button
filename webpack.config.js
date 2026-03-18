const path = require( 'path' );

module.exports = {
  mode: 'production',
  entry: './src/js/admin/manager.js',
  output: {
    filename: 'admin.js',
    path: path.resolve( __dirname, 'js' )
  },
};
