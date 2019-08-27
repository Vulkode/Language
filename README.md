# Language PocketMine
Language api for servers of minecraft pe (bedrock edition)

## ¿How to usage the API?

- Added instance of Language Plugin:
```PHP
use Language\Language;
```
- Functions of Language API:
```PHP
Language::getLanguage(Player $player); // return String 
Language::getTranslate(Plugin $plugin, Player $player, string $params); // return string
```

### ¿How to added Language in Your Plugin?

```TXT
- Add file Of language format in plugin data /languages/: eng.yml
- Add prefix of translate example: 
  - eng.yml > my.message: 'Wellcome'
  - spa.yml > my.message: 'Bienvenido'
```

### Credits
This plugin create by **SharpyKurth**.
