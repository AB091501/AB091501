
# Tutorial: Regex matching Hex value

Regular expressions are patterns used to match character combinations in strings. In a regular expression the metacharacter ^ means "not". So, while "a" means "match lowercase a", "^a" means "do not match lowercase a".

## Summary
Today I will be covering and breaking down the components of a regular expression used to match Hex Values. Hexadecimal code is a system by which any specific color can be described accurately to a computer, ensuring consistency and accuracy in an electronic display. A hexadecimal color value is a six-digit code preceded by a # sign; it defines a color that is used in a website or a computer program.
/^#?([a-f0-9]{6}|[a-f0-9]{3})$/

## Table of Contents

- [Back-references](#back-references)
- [Look-ahead and Look-behind](#look-ahead-and-look-behind)
- [Greedy and Lazy Match](#greedy-and-lazy-match)

## Regex Components

### Back-references

Back references How do back references appear? Typically, a single-digit is followed by a backslash (\). A command known as a "back-reference" refers to an event that has already occurred or a previous portion of a matched regular phrase. In essence, you are referring to a named group and would have a pillow/and a G then the name of that group, for example. You may make a better choice by name or number.

### Look-ahead and Look-behind

Regular expressions' look ahead and look behind capabilities enable the handling of matches. In particular, I looked at the look-ahead and look-behind zero-length assertions on the website regex buddy, which also claims to be a regular Dash expression.info. Look ahead and look behind assertions, often referred to as look around assertions, are comparable to a line's beginning and end or anchors. However, characters can be matched by looking about, and they then either produce a match or no match result.

### Greedy and Lazy Match

/^#`?`([a-f0-9]{6}|[a-f0-9]{3})$/  
A greedy match tries to match an element as many times as possible. Whereas, a lazy match tries to match an element as few times as possible. In our example we have `?` which signifies lazy quantifier. This is referred to a lazy quantifier because it causes the regular expression engine to match as few occurances as possible. We can simply turn this lazy match into a greedy one by adding a `?`.

## Author

Hi I'm Eric Enriquez, I'm a full-stack developer student looking to succeed and dominate the web.  
GitHub: [Eric-JG](https://github.com/Eric-JG)
