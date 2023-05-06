//do while
var i = 0;
do {
    ++i
    // console.log(i)
} while (i < 10)

for (const arrayKey in [2, 4, 6, 9]) {
    console.log(arrayKey)
}
var num = 0
for (let i = 1; i < 10; i++) {
    if (i % 5 == 0) {
        continue;
    }
    num++
}
console.log(num)


var num = 0;
outermost:
    for (let i = 0; i < 10; i++) {
        for (let j = 0; j < 10; j++) {
            if (i == 5 && j == 5) {
                break outermost;
            }
            num++;
        }
    }
console.log(num)

for (const arrayKey of "aa") {
    console.log(arrayKey)
}
