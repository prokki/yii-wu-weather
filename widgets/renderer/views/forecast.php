<?php
/**
 * @var WuWeatherStandardResponseModel $response
 * @var bool                           $use_fahrenheit
 */
?><table border="1">
    <tbody>
    <tr>
        <?php foreach( $response->forecast->simpleforecast->forecastday as $_day ): ?>
            <td>
				<?= $_day->date->format("d.m.Y"); ?>
            </td>
		<?php endforeach; ?>
    </tr>

    <tr>
		<?php foreach( $response->forecast->simpleforecast->forecastday as $_day ): ?>
            <td>
				<?= CHtml::image($_day->icon_url); ?>
            </td>
		<?php endforeach; ?>
    </tr>

    <tr>
		<?php foreach( $response->forecast->simpleforecast->forecastday as $_day ): ?>
            <td>
				<?php printf("%s°C / %s°C",
					$use_fahrenheit ? $_day->high->fahrenheit : $_day->high->celsius,
					$use_fahrenheit ? $_day->low->fahrenheit : $_day->low->celsius
				); ?>
            </td>
		<?php endforeach; ?>
    </tr>

    <tr>
		<?php foreach( $response->forecast->simpleforecast->forecastday as $_day ): ?>
            <td>
				<?php printf("%d %%", $_day->pop); ?>
            </td>
		<?php endforeach; ?>
    </tr>

    <tr>
		<?php foreach( $response->forecast->simpleforecast->forecastday as $_day ): ?>
            <td>
				<?php printf("%d %%", $_day->avehumidity); ?>
            </td>
		<?php endforeach; ?>
    </tr>

    </tbody>
</table>