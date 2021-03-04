module.exports = {
  ci: {
    collect: {
      startServerCommand: 'php artisan serve',
      url: ['http://localhost:8000'],
      settings: {chromeFlags: '--no-sandbox'},
    },
    upload: {
      target: 'temporary-public-storage',
    },
  },
};
