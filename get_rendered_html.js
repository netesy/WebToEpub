const puppeteer = require('puppeteer');

(async () => {
    const url = process.argv[2];
    if (!url) {
        console.error('Please provide a URL as an argument.');
        process.exit(1);
    }

    let browser;
    try {
        browser = await puppeteer.launch({
            headless: true,
            args: ['--no-sandbox', '--disable-setuid-sandbox']
        });
        const page = await browser.newPage();
        await page.goto(url, { waitUntil: 'networkidle0' });

        if (url.includes('wtr-lab.com')) {
            const tocButtonSelector = '#contents-tab-toc';
            await page.waitForSelector(tocButtonSelector);
            await page.click(tocButtonSelector);

            const accordionButtons = await page.$$('.accordion-button');
            for (let i = 0; i < accordionButtons.length; i++) {
                await accordionButtons[i].click();
                // Wait for the content of the specific panel to load
                await page.waitForSelector(`.accordion-item:nth-child(${i + 1}) .accordion-body a`);
            }
        }

        const content = await page.content();
        console.log(content);
    } catch (error) {
        console.error('Error fetching the page:', error);
        process.exit(1);
    } finally {
        if (browser) {
            await browser.close();
        }
    }
})();
