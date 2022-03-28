const path = require('path');

const isDev = process.env.NODE_ENV !== 'production';
const isProd = !isDev;
const MiniCss = require('mini-css-extract-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserWebpackPlugin = require('terser-webpack-plugin');
const Autoprefixer = require('autoprefixer');
const {VueLoaderPlugin} = require('vue-loader');

const {CleanWebpackPlugin} = require('clean-webpack-plugin');
// const pathsToClean = [ 'dist'];
// const cleanOptions = { root: __dirname, verbose: true, dry: false, exclude: [],};

const optimization = () => {
    const config = {}

    if(isDev) {
        config.minimizer = [
            new OptimizeCssAssetsPlugin(),
            new TerserWebpackPlugin()
        ]
    }

    return config;
}

module.exports = {
    entry: {
        public: ['@babel/polyfill', path.resolve(__dirname, 'src/app/public.js')],
        admin: [path.resolve(__dirname, 'src/app/admin.js')]
    },
    output: {
        path: path.resolve(__dirname, 'dist/build'),
        filename: '[name].bundle.js',
    },
    optimization: optimization(),
    devtool: isDev ? 'source-map' : false,
    plugins: [
        new CleanWebpackPlugin(),
        new VueLoaderPlugin(),
        new MiniCss(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.js'
        },
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                        plugins: ['@babel/plugin-proposal-class-properties']
                    }
                },
                exclude: [
                    /node_modules/
                ]
            },
            {
                test: /\.s[a|c]ss$/,
                use: [
                    MiniCss.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            url: false
                        }
                    },
                    {
                        loader: "postcss-loader",
                        options: {
                            postcssOptions: {
                                plugins: [
                                    [
                                        Autoprefixer(),
                                        "postcss-preset-env",
                                        {
                                            // Options
                                        },
                                    ],
                                ],
                            },
                        },
                    },
                    'sass-loader'
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    scss: 'vue-style-loader!css-loader!sass-loader'
                }
            }
        ]
    }
};