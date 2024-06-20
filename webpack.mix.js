const mix = require('laravel-mix');
const webpack = require('webpack');
require('dotenv').config();

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .webpackConfig({
       plugins: [
           new webpack.DefinePlugin({
               'process.env': {
                   MIX_FIREBASE_API_KEY: JSON.stringify(process.env.MIX_FIREBASE_API_KEY),
                   MIX_FIREBASE_AUTH_DOMAIN: JSON.stringify(process.env.MIX_FIREBASE_AUTH_DOMAIN),
                   MIX_FIREBASE_DATABASE_URL: JSON.stringify(process.env.MIX_FIREBASE_DATABASE_URL),
                   MIX_FIREBASE_PROJECT_ID: JSON.stringify(process.env.MIX_FIREBASE_PROJECT_ID),
                   MIX_FIREBASE_STORAGE_BUCKET: JSON.stringify(process.env.MIX_FIREBASE_STORAGE_BUCKET),
                   MIX_FIREBASE_MESSAGING_SENDER_ID: JSON.stringify(process.env.MIX_FIREBASE_MESSAGING_SENDER_ID),
                   MIX_FIREBASE_APP_ID: JSON.stringify(process.env.MIX_FIREBASE_APP_ID),
               }
           })
       ],
   });
