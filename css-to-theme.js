const fs = require("fs");
const path = require("path");
const css = require("css");
const _ = require("lodash");

const cssPath = path.resolve(__dirname, "./styling/blocks/core/");
const themePath = path.resolve(__dirname, "./theme.json");

// load theme.json
let theme = {};
if (fs.existsSync(themePath)) {
  theme = JSON.parse(fs.readFileSync(themePath, "utf8"));
  console.log(theme);
}

const files = fs.readdirSync(cssPath);
files.forEach((file) => {
  const fileName = file.replace(".css", "");
  const filePath = path.resolve(cssPath, file);
  const rawCss = css.parse(fs.readFileSync(filePath, "utf8"));
  const stringifiedCss = css.stringify(rawCss, {
    compress: true,
  });

  if (!theme.styles.hasOwnProperty("blocks")) {
    theme.styles.blocks = {};
  }

  if (!theme.styles.blocks.hasOwnProperty(`core/${fileName}`)) {
    theme.styles.blocks[`core/${fileName}`] = {};
  }

  theme.styles.blocks[`core/${fileName}`].css = stringifiedCss;
  
  
});

fs.writeFileSync(themePath, JSON.stringify(theme, null, 2));
