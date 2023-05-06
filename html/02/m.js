let mySymbol = Symbol();
console.log(Object(mySymbol))

let fooGlobalSymbol = Symbol.for('foo');
console.log(typeof fooGlobalSymbol) // symbol

let otherFooGlobalSymbol = Symbol.for("foo");
console.log(fooGlobalSymbol === otherFooGlobalSymbol)//true

//采用相同的符号描述,在全局注册表中跟使用Symbol()定义的符号也并不相同
let localSymbol = Symbol('foo')
console.log(otherFooGlobalSymbol === localSymbol)//false

for (const localSymbolKey in navigator) {
    console.log(localSymbolKey)
}