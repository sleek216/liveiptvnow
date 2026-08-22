import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.resolve(__dirname, '..');
const jsPath = path.join(root, 'public_html', 'js', 'translations.js');
const langDir = path.join(root, 'lang');

const content = fs.readFileSync(jsPath, 'utf8');
const marker = 'const translations = ';
const start = content.indexOf(marker);

if (start === -1) {
    console.error('Could not find translations object');
    process.exit(1);
}

let i = content.indexOf('{', start);
let depth = 0;
let inString = false;
let stringChar = '';
let escaped = false;
const objStart = i;

for (; i < content.length; i++) {
    const ch = content[i];

    if (inString) {
        if (escaped) {
            escaped = false;
            continue;
        }
        if (ch === '\\') {
            escaped = true;
            continue;
        }
        if (ch === stringChar) {
            inString = false;
        }
        continue;
    }

    if (ch === '"' || ch === "'") {
        inString = true;
        stringChar = ch;
        continue;
    }

    if (ch === '{') {
        depth++;
        continue;
    }

    if (ch === '}') {
        depth--;
        if (depth === 0) {
            break;
        }
    }
}

const objCode = content.slice(objStart, i + 1);
const translations = Function(`"use strict"; return (${objCode});`)();

for (const locale of Object.keys(translations)) {
    const jsonPath = path.join(langDir, `${locale}.json`);
    let existing = {};

    if (fs.existsSync(jsonPath)) {
        existing = JSON.parse(fs.readFileSync(jsonPath, 'utf8'));
    }

    const merged = { ...existing, ...translations[locale] };
    const sorted = Object.fromEntries(
        Object.keys(merged).sort((a, b) => a.localeCompare(b)).map((key) => [key, merged[key]])
    );

    fs.writeFileSync(jsonPath, `${JSON.stringify(sorted, null, 4)}\n`);
    console.log(`Synced ${locale}.json (${Object.keys(sorted).length} keys)`);
}

const publicJs = path.join(root, 'public', 'js', 'translations.js');
if (fs.existsSync(publicJs)) {
    fs.copyFileSync(jsPath, publicJs);
    console.log('Copied translations.js to public/js');
}
