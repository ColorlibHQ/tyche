import { chromium } from 'playwright';
const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1440, height: 900 }, deviceScaleFactor: 2 });
await page.goto(process.argv[2], { waitUntil: 'networkidle' });
await page.waitForTimeout(1000);
const d = await page.evaluate(() => {
  const g = (s) => { const e = document.querySelector(s); if (!e) return null; const b = e.getBoundingClientRect(); return { x: Math.round(b.x), c: Math.round(b.x + b.width / 2) }; };
  const h1 = document.querySelector('h1'); const r = document.createRange(); r.selectNodeContents(h1);
  return { brand: g('.tyche-header__brand'), search: g('.tyche-header__search'), nav: g('.tyche-header__subnav'),
           h1: [...r.getClientRects()].map(x => Math.round(x.width)) };
});
console.log(`brand@${d.brand.x} nav@${d.nav?.x} | search centre ${d.search.c} of 720 | h1 lines ${JSON.stringify(d.h1)}`);
if (process.argv[3]) await page.screenshot({ path: process.argv[3] });
await browser.close();
