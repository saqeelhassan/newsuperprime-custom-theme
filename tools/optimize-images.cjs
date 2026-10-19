/**
 * Compress theme images in place (same names, same formats).
 *
 * Put this file in:  newsuperprime-theme/tools/optimize-images.cjs
 * Run from the theme folder:
 *   npm install --no-save sharp
 *   node tools/optimize-images.cjs
 *
 * - First run copies assets/img to assets/img-original (backup). Later runs
 *   always start from that backup, so quality never degrades on repeat runs.
 * - A file is only replaced when the new version is smaller.
 * - SVG and GIF files are left untouched.
 * - Do NOT deploy assets/img-original to the server.
 */
const fs = require('fs');
const path = require('path');
const sharp = require('sharp');

const THEME = path.resolve(__dirname, '..');
const IMG = path.join(THEME, 'assets', 'img');
const BACKUP = path.join(THEME, 'assets', 'img-original');

// Max width per folder (px). Images are never enlarged.
// Logos are shown small, so 2x their display size is plenty.
const MAX_WIDTH = {
  logo: 500,
  icon: 160,
  shape: 800,
  blog: 800,
  project: 900,
  about: 900,
  default: 1920,
};

const JPEG_QUALITY = 80;
const PNG_QUALITY = 80;

function walk(dir) {
  return fs.readdirSync(dir, { withFileTypes: true }).flatMap((e) => {
    const p = path.join(dir, e.name);
    return e.isDirectory() ? walk(p) : [p];
  });
}

function maxWidthFor(rel) {
  const folders = rel.split(path.sep).slice(0, -1);
  // Also cover nested template folders such as img-5/project and img-5/about.
  const folder = folders.find(name => name === 'project' || name === 'about') || folders[0];
  return MAX_WIDTH[folder] || MAX_WIDTH.default;
}

async function main() {
  if (!fs.existsSync(IMG)) {
    console.error('Not found: ' + IMG + '\nRun this from the theme folder.');
    process.exit(1);
  }
  if (!fs.existsSync(BACKUP)) {
    fs.cpSync(IMG, BACKUP, { recursive: true });
    console.log('Backup created: assets/img-original\n');
  }

  let before = 0;
  let after = 0;

  for (const src of walk(BACKUP)) {
    const rel = path.relative(BACKUP, src);
    const dest = path.join(IMG, rel);
    const ext = path.extname(src).toLowerCase();
    if (!['.jpg', '.jpeg', '.png'].includes(ext)) continue;

    const input = fs.readFileSync(src);
    let pipeline = sharp(input).rotate().resize({
      width: maxWidthFor(rel),
      withoutEnlargement: true,
    });

    pipeline = ext === '.png'
      ? pipeline.png({ palette: true, quality: PNG_QUALITY, compressionLevel: 9, effort: 10 })
      : pipeline.jpeg({ quality: JPEG_QUALITY, mozjpeg: true, progressive: true });

    const output = await pipeline.toBuffer();
    const best = output.length < input.length ? output : input;
    fs.mkdirSync(path.dirname(dest), { recursive: true });
    fs.writeFileSync(dest, best);

    before += input.length;
    after += best.length;
    const pct = Math.round((1 - best.length / input.length) * 100);
    console.log(`${rel.padEnd(45)} ${kb(input.length)} -> ${kb(best.length)}  (-${pct}%)`);
  }

  console.log(`\nTotal: ${kb(before)} -> ${kb(after)}  (-${Math.round((1 - after / before) * 100)}%)`);
}

const kb = (n) => (n / 1024).toFixed(0).padStart(5) + ' KB';

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
