# Convert
Converts Png and Json to Work With Models

# Шаги:
- Переводим текстуру в формат для игры.
```php
$skin = ModelConvert::getSkinFromFile($texture);
```

 - Входные данные обязательно должны иметь одно имя.
```php
 $geometry = ModelConvert::makeGeometrySkin($skin, $path, $geometryName);
```

 - Создаем наш NBT с вектором, заполняем CompoundTag и получаем мир.
```php
 $nbt = ModelConvert::createEntityBaseNBT(new Vector3(100, 50, 100));
 
 $npc = ModelConvert::pushCompoundTag($nbt, $geometry);
 
 $level = Server::getInstance()->getLevelByName('world');
 ```
 
  - Передаем класс и собираем все данные, а после отправляем всем.
```php
$entity = ModelConvert::createEntity("Quester", $level, $nbt);
$entity->spawnToAll();
 ```

![Convert](https://github.com/iteplenky/Convert/blob/main/Convert.png)
