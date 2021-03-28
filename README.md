[![Build Status](https://travis-ci.com/grizz-it/cli.svg?branch=master)](https://travis-ci.com/grizz-it/cli)

# GrizzIT CLI

This package contains elements for reading and writing in a CLI environment.
It provides elements for easily rendering elements in a CLI environment.
It supports creating CLI forms and even theming all of this.

## Installation

To install the package run the following command:

```
composer require grizz-it/cli
```

## Usage

### Elements

Elements implementing the [ElementInterface](src/Common/Element/ElementInterface.php),
are a standard set of elements which render in a specific style to the user.
These elements are fully customizable through theming (which will be covered later on).

The available elements are:

#### [BlockElement](src/Component/Element/BlockElement.php)
This is block for presenting content in a larger stage.
It has configurable margins, paddings and colors.

#### [ChainElement](src/Component/Element/ChainElement.php)
The chain element itself is not an actual element, but an element
to chain more elements into one, so this can be provided to methods
which only accept one element.

#### [ExplainedListElement](src/Component/Element/ExplainedListElement.php)
The explained list element is an element that displays a nesting
list of entries with a description. The element can be customized with colors.
The items can be added by providing a description followed by a set of keys to determine the position in the list.

#### [FormElement](src/Component/Element/FormElement.php)
The form element is a wrapping element for rendering forms.
After it has been rendered once, the values can be retrieved with the `getInput` method.
The form element itself can not be customised, but the provided description can be styled.

#### [ListElement](src/Component/Element/ListElement.php)
The list element is a simple multi line renderer.
It simply renders all items on a new line in a given style.

#### [ProgressElement](src/Component/Element/ProgressElement.php)
The progress element is used for displaying a progress bar.
This utilizes the `TaskList` from `grizz-it/task` to render.

#### [TableElement](src/Component/Element/TableElement.php)
The table element is a fully customizable (including the borders)
table. It only renders the keys that have been defined of the array of items that is provided.

#### [TextualElement](src/Component/Element/TextualElement.php)
The textual element is a simple text element which can be customized using a style.
It has the option to render a new line of the element or not.

### Form elements

The form elements are the elements used to render the form and retrieve input from the user.

There are two types of form elements provided in this package,
which are [Field](src/Component/Element/Form/Field.php).
The field provides a simple one value form.

The other field type is an [ArrayField](src/Component/Element/Form/ArrayField.php). This field is used to receive multiple options from the user.

Both of these fields have customizable behaviour through their provided [Reader](src/Common/Io/ReaderInterface.php).

Fields need to be accompanied by a [FieldValidator](src/Component/Element/Form/FieldValidator.php), when they are provided to the form.
These validators are a combination of a `Validator` from the `grizz-it/validator` package and an element for rendering an error.

### IO

The IO namespace is used for Input and Output directly to and from the user.

#### Readers

Within the IO namespace `Readers` are used to record user input to provide information to the application.
The available readers are the following:

##### [ErrorReader](src/Component/Io/ErrorReader.php)
The error reader is used to always throw an error when reading is disabled.
For example when an application uses a no interaction flag.
This reader can be used to disable the interaction.

##### [Reader](src/Component/Io/Reader.php)
The Reader (standard reader) is a reader that uses the stdin from the CLI to read user input.

##### [SttyAutocompletingReader](src/Component/Io/SttyAutocompletingReader.php)
This reader uses (and expects) `stty` in the console to provide a layer over the stdin to provide an autocompleting experience.
It expects an [OptionProvider](src/Common/Io/OptionProviderInterface.php) to resolve the autocompletion options. A standard implementation is provided [here](src/Component/Io/OptionProvider.php).

##### [SttyObscuredReader](src/Component/Io/SttyObscuredReader.php)
This reader uses `stty` to remove the visibility of the input the user provides to the application.
This can be helpfull when the user has to provide a password.

#### [Writer](src/Component/Io/Writer.php)
The writer is used to output information to the user in the CLI directly.
All output will be immediatly flushed to the user when a method is invoked.

#### [Styler](src/Component/Io/Styler.php)
The styler is used to output a style when writing to the output.
Styling can be applied by providing one or more enum values to the styler.
The options are defined in the [StyleEnum](src/Common/Theme/StyleEnum.php).
To learn how to use enums, see the `grizz-it/enum` package for more details.

#### [Pointer](src/Component/Io/Pointer.php)
The pointer class can be used to manipulate the pointer in the terminal.
This can be usefull when overwriting text and rendering elements.

#### Terminal
The terminal classes are used to determine the height and width of the terminal of the user.
This can be usefull when elements need to be rendered within the
bounds of the terminal.
There are two options provided with the package.
[SttyTerminal](src/Component/Io/SttyTerminal.php) uses `stty` to determine the size of the terminal.
[TputTerminal](src/Component/Io/TputTerminal.php) uses `tput` to determine the size of the terminal.

### Theming
Theming is used to differentiate the looks of elements used within the application.
Styles can be retrieved with the [StyleEnum](src/Common/Theme/StyleEnum.php).
To learn how to use enums, see the `grizz-it/enum` package for more details.

These enum styles can be bound to a [ConfigurableStyle](src/Component/Theme/ConfigurableStyle.php) to combine and render them.

These configurable styles can then be used in a
[Theme](src/Component/Theme/Theme.php) to unify the styling throughout the application.
Theme also accept setting variables, so things like margin, padding and characters for elements can be configured as well.

An [ApplicationTheme](src/Common/Theme/ApplicationThemeInterface.php) is provided with the package and shows the default values for
all provided elements within the package.
This theme can be found [here](src/Component/Theme/DefaultTheme.php).

### Factories

For all these elements, factories have been made available.
- [ElementFactory](src/Factory/ElementFactory.php)
- [FormFactory](src/Factory/FormFactory.php)
- [IoFactory](src/Factory/IoFactory.php)
- [ThemeFactory](src/Factory/ThemeFactory.php)

### Generators

For simplifying the creation of themes and forms two generators have been created.
- [FormGenerator](src/Generator/FormGenerator.php)
- [ThemeGenerator](src/Generator/ThemeGenerator.php)

These two classes provide method which support chaining for quickly generator a form and/or theme.

## Examples

Examples can be found in the [examples](examples) directory.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## MIT License

Copyright (c) GrizzIT

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
