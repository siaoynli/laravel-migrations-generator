<?php namespace Siaoynli\MigrationsGenerator\Syntax;

/**
 * Class AddToTable
 * @package OscarAFDev\MigrationsGenerator\Syntax
 */
class AddToTable extends Table
{

    /**
     * Return string for adding a column
     *
     * @param array $field
     * @return string
     */
    protected function getItem(array $field)
    {

        $property = $field['field'];

        $type = $field['type'];

        // If the field is an array,
        // make it an array in the Migration
        if (is_array($property)) {
            $output = sprintf(
                "\$table->%s(%s)",
                $type,
                "['" . implode("','", $property) . "']"
            );

        } else {
            $property = $property ? "$property" : null;
            if ($property) {
                $output = sprintf(
                    "\$table->%s('%s')",
                    $type,
                    $property
                );

            } else {
                $output = sprintf(
                    "\$table->%s()",
                    $type,
                );
            }
        }


        if (isset($field['args']) && $type !== 'text') {
            if ($property == null) {
                $output = sprintf(
                    "\$table->%s()",
                    $type
                );
            } else {
                if (is_array($property)) {
                    $property = "['" . implode("','", $property) . "']";
                    $output = sprintf(
                        "\$table->%s(%s, %s)",
                        $type,
                        $property,
                        $field['args']
                    );
                } else {
                    $output = sprintf(
                        "\$table->%s('%s', %s)",
                        $type,
                        $property,
                        $field['args']
                    );
                }

            }
        }
        if (isset($field['decorators'])) {

            $output .= $this->addDecorators($field['decorators']);
        }


        return $output . ';';
    }
}
