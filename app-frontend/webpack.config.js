const path = require('path');
const webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const Dotenv = require('dotenv-webpack');
const CopyPlugin = require('copy-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = (env, argv) => {
    return {
        mode: 'development',
        entry: {
            index: './src/index.js',
        },
        plugins: [
            new HtmlWebpackPlugin({
                template: './public/index.html',
                favicon: './public/favicon.ico',
                manifest: './public/manifest.json',
            }),
            new CopyPlugin({
                patterns: [
                    { from: './public/assets/', to: './assets' },
                    { from: './public/.htaccess', to: './' },
                    { from: './public/logo144.png', to: './' },
                    { from: './public/apple-touch-icon.png', to: './' },
                    { from: './public/android-chrome-icon.png', to: './' },
                    { from: './public/contact-us/', to: './contact-us' },
                    { from: './public/company-request/', to: './company-request' },
                ],
            }),
            new Dotenv(),
            new webpack.ProvidePlugin({
                React: 'react',
            }),
            new CleanWebpackPlugin(),
        ],
        output: {
            filename: '[name]-[fullhash].bundle.js',
            path: path.resolve(__dirname, 'build'),
            publicPath: '/',
        },
        devServer: {
            host: '0.0.0.0',
            historyApiFallback: true,
        },
        performance: {
            maxAssetSize: 1024000000,
            maxEntrypointSize: 1024000000,
            hints: argv.mode === 'production' ? false : 'warning',
        },
        module: {
            rules: [
                {
                    test: /\.(js|jsx|tsx|ts)?$/,
                    exclude: /node_modules/,
                    use: ['babel-loader', 'ts-loader'],
                },
                {
                    test: /\.css$/,
                    use: ['style-loader', 'css-loader'],
                },
                {
                    test: /\.s[ac]ss$/i,
                    use: [
                        // Creates `style` nodes from JS strings
                        'style-loader',
                        // Translates CSS into CommonJS
                        'css-loader',
                        // Compiles Sass to CSS
                        'sass-loader',
                    ],
                },
                {
                    test: /\.(jpe?g|png|gif|svg)$/i,
                    loader: 'file-loader',
                },
            ],
        },
        resolve: {
            alias: {
                '@': path.resolve(__dirname, './src')
            },
            extensions: ['.js', '.jsx', '.tsx', '.ts', '.json']
        },
    };
};
