const path = require( 'path' );
const CopyPlugin = require( 'copy-webpack-plugin' );

module.exports = {
  entry: './src/js/admin/manager.js',
  output: {
    filename: 'admin.js',
    path: path.resolve( __dirname, 'js' )
  },
  plugins: [
    new CopyPlugin({
      patterns: [
        { from: 'src/js/frontend', to: path.resolve( __dirname, 'js' ) },
      ],
    }),
  ],
};