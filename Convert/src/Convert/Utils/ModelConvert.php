<?php

declare(strict_types = 1);

namespace Convert\Utils;

  use Convert\Main;  

  use pocketmine\level\Level;
  use pocketmine\math\Vector3;
  use pocketmine\entity\{Skin, Entity};
  use pocketmine\nbt\tag\{ByteArrayTag, CompoundTag, StringTag, IntTag};

    class ModelConvert
    {
        public static function createEntity(string $class, Level $level, CompoundTag $nbt): Entity
        {
            return Entity::createEntity($class, $level, $nbt);
        }

        public static function createEntityBaseNBT(Vector3 $vector, ?Vector3 $motion = null, float $yaw = 0.0, float $pitch = 0.0): CompoundTag
        {
            return Entity::createBaseNBT($vector, $motion, $yaw, $pitch);
        }

        public static function pushCompoundTag(CompoundTag &$nbt, Skin $skin): void
        {
            $nbt->setTag(new CompoundTag("Skin", [
                new StringTag('Name', $skin->getSkinId()),
                new ByteArrayTag('Data', $skin->getSkinData()),
                new ByteArrayTag('CapeData', $skin->getCapeData()),
                new StringTag('GeometryName', $skin->getGeometryName()),
                new ByteArrayTag('GeometryData', $skin->getGeometryData())
            ]));
            $nbt->setTag(new IntTag("position"));
            $nbt->setTag(new StringTag("player", "0"));
        }

        public static function getSkinFromFile(string $path) : ?Skin
        {
            $img = @imagecreatefrompng($path);
            $bytes = '';
            $l = (int) @getimagesize($path)[1];
            for ($y = 0; $y < $l; $y++) {
                for ($x = 0; $x < 64; $x++) {
                    $rgba = @imagecolorat($img, $x, $y);
                    $a = ((~((int)($rgba >> 24))) << 1) & 0xff;
                    $r = ($rgba >> 16) & 0xff;
                    $g = ($rgba >> 8) & 0xff;
                    $b = $rgba & 0xff;
                    $bytes .= chr($r) . chr($g) . chr($b) . chr($a);
                }
            }
            @imagedestroy($img);
            return new Skin("name", $bytes);
        }

        public static function makeGeometrySkin(Skin $skin, string $path, string $geometryName): Skin
        {
            if (!file_exists($path . $geometryName . ".json") or !file_exists($path . $geometryName . ".png"))
                return $skin;
        
            $img = imagecreatefrompng($path . $geometryName . ".png");
            $bytes = "";
            $size = getimagesize($path . $geometryName . ".png")[1];
        
            for ($y = 0; $y < $size; $y ++) {
                for ($x = 0; $x < 64; $x ++) {
                    $colorat = imagecolorat($img, $x, $y);
                    $a = ((~((int) ($colorat >> 24))) << 1) & 0xff;
                    $r = ($colorat >> 16) & 0xff;
                    $g = ($colorat >> 8) & 0xff;
                    $b = $colorat & 0xff;
                    $bytes .= chr($r) . chr($g) . chr($b) . chr($a);
                }
            }
            imagedestroy($img);
            return new Skin($skin->getSkinId(), $bytes, "", "geometry." . $geometryName, file_get_contents($path . $geometryName . ".json"));
        }
    }

?>
