import vue from '@vitejs/plugin-vue'
import path from "path";
import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";
import tailwindConfig from "./tailwind.config";
export default ({ command }) => ({
    base: command === 'serve' ? '' : '/vendor/lvg/',
    publicDir: 'fake_dir_so_nothing_gets_copied',
    server: {
        origin: 'http://localhost:3000'
    },
    resolve: {
        alias: {
            '~': path.resolve('Core/Resources'),
            '@': path.resolve('Core/Js'),
            '@Lvg': path.resolve(''),
            '@tailwindConfig': path.resolve('tailwind.config')
        },
        extensions: ['.mjs', '.js', '.ts', '.jsx', '.tsx', '.json', '.vue']
    },
    plugins: [vue()],
    build: {
        manifest: true,
        outDir: '../public/vendor/lvg',
        emptyOutDir: true,
        rollupOptions: {
            input: './Core/Js/main.ts',
        },
    },
    css: {
        postcss: {
            plugins: [
                tailwindcss(tailwindConfig as any),
                autoprefixer,
            ]
        },
    }
});
