/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
const fs = require('fs');
const content = fs.readFileSync('../src/pages/Index.tsx', 'utf-8');

const match = content.match(/const topCollegesByCountry.*?=\s*({[\s\S]*?});/);
if (!match) {
    console.log("Could not find topCollegesByCountry");
    process.exit(1);
}

// Evaluate the object (we have to replace some stuff to make it parseable as JS)
let objStr = match[1];
// Some quick hacks to make it parseable
// It's mostly valid JS object
const funcStr = `return ${objStr};`;
const fn = new Function(funcStr);
const data = fn();

let sql = `TRUNCATE TABLE universities;\n`;

for (const country in data) {
    if (country === "Global") continue; // Global is just a duplicate
    
    for (const uni of data[country]) {
        const c = uni.country.replace(/'/g, "''");
        const r = uni.rank;
        const n = uni.name.replace(/'/g, "''");
        const s = uni.short.replace(/'/g, "''");
        const city = uni.city.replace(/'/g, "''");
        const flag = uni.flag;
        const rating = uni.rating;
        const ranking = uni.ranking.replace(/'/g, "''");
        const cutoff = uni.cutoff.replace(/'/g, "''");
        const deadline = uni.deadline.replace(/'/g, "''");
        const fees = uni.fees.replace(/'/g, "''");
        
        sql += `INSERT INTO universities (country, \`rank\`, name, short_name, city, flag, rating, ranking_text, cutoff, deadline, fees) VALUES ('${c}', ${r}, '${n}', '${s}', '${city}', '${flag}', ${rating}, '${ranking}', '${cutoff}', '${deadline}', '${fees}');\n`;
    }
}

fs.writeFileSync('universities_seed.sql', sql);
console.log("universities_seed.sql generated");
