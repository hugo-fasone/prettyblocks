import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  base: '/modules/prettyblocks/src/Resources/editor/',
  plugins: [vue()],
  build: {
    manifest: true,
    outDir: "../public/",
    emptyOutDir: true,
    rollupOptions: {
      output: {
        entryFileNames: 'prettyblocks_editor.js',
        chunkFileNames: 'prettyblocks_editor.js',
      }
    }
  },
  server: {
    host: '0.0.0.0',
    https: true,
    port: 3000,
    hmr: {
      host: 'raviday_core.app.localhost',
      protocol: 'ws'
    }
  }
})
