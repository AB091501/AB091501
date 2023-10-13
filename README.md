# Regex Tutorial: MATCHING AN HTML TAG 

In this tutorial, we will learn how to use a regular expression (regex) to match an HTML tag. HTML tags are fundamental elements in web development, and understanding how to match them using regex can be a powerful tool.

## Summary
Today I will be covering and breaking down the components of a regular expression used to match HTML tag. HTML tags are used to structure the content of a web page. They consist of an opening tag, content, and a closing tag. Matching HTML tags with regex can be useful for parsing and extracting data from web pages or validating HTML content.
/^<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)$/

## Table of Contents

- [The HTML Tag Structure](#the-html-tag-structure)
- [Matching HTML Tags with a Regex](#matching-html-tags-with-a-regex)

## Regex Components


### The HTML Tag Structure

An HTML tag has the following structure:
- An opening tag starts with < and ends with >.
- The closing tag starts with </ and ends with >.
For example, here is an HTML tag structure:
`<p>This HTML tags is considered as a paragraph.</p>`
In the example, `<p>` will be the opening tag, and `</p>` will be the closing tag.

### Matching HTML Tags with a Regex
To match HTML tags with a regex, we can use the following pattern:
/^<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)$/
- `'/^'` and `$/`: These are the start and end anchors. They ensure that the regex matches the entire string from the beginning to the end.
- `<` and `>`: These characters match the opening and closing angle brackets of HTML tags.


## Author

Hi I'm Eric Enriquez, I'm a full-stack developer student looking to succeed and dominate the web.  
GitHub: [Eric-JG](https://github.com/Eric-JG)
