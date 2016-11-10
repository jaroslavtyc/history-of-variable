#### _Where did this value come from?_

#### _What changes this value passed through?_

_During my game project I have find out that just a **result** of a calculation is not enough._

_Users require whole **calculation** of the result, **transparent and descriptive**, from very first value to the final._

_That is easy for five, maybe twenty different calculations. But not hundreds..._

## Goal - all changes of a variable

Variable can be changed clearly by an arithmetic calculation or hideously by a method or function.

```php
...
$strength = $race->getStrength(); // initial value, let say +3
$strength += $bonusFromHeight; // simple addition from a variable, let say 3 += 2
$strength += calculateMalusFromFatigue($body->getFatigue()); // simple addition from a function result, let say 5 += -1
echo $strength; // 4
```
- such code should be described as a
```
strength 4 (race strength 3 + bonus from height 2 - calculate malus from fatigue 1)
```
Not bad but, what about the fatigue? We interested in its value as well.

- extended description
```
strength 4 (race strength 3 + bonus from height 2 - malus from fatigue 1 (fatigue 4))
```
And the history of fatigue would be nice too...

### Technical difficulties
But how to achieve that? By evaluating row by row once again by splitting code to steps and `eval()`?

Or grabbing values by Xdebug, which slows the code execution ten times?

- we can get a lot information by `debug_backtrace()`
    - but only entry points
        - it tracks for us used interface and passed values
        - it does NOT show us all the rows executed

to be continued...