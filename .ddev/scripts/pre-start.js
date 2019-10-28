const fs = require('fs')
const path = '.ddev/.env.local';

if (!fs.existsSync(path)) {
    console.error('You must copy the file .ddev/.env to .ddev/.env.local and supply values for your local environment prior to running this stack');
}
