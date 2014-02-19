<?php

// This command searches through all the songs that are missing waveform images and adds them.
class CreateWaveformsCommand extends CConsoleCommand
{
	public function run($args)
	{
		Yii::import('application.components.WaveImageMaker');

		$criteria = new CDbCriteria();
		$criteria->select = 'id, title, file_name';
		$criteria->condition = 'waveform_image IS NULL';

		$songs = Song::model()->findAll($criteria);

		foreach($songs as $song) {

			printf("Processing: %s\n", $song->title);
			print("=====================================\n");

			printf("\tsongsFolder\t[%s]\n", $song->songsFolder);
			printf("\tsongFilePath\t[%s]\n", $song->songFilePath);

			printf("\twaveImagesFolder\t[%s]\n", $song->waveImagesFolder);
			printf("\twaveImageFilePath\t[%s]\n", $song->waveImageFilePath);

			print("\n\n");

			$imgMaker = new WaveImageMaker(array(
				'mp3_filename'	=> $song->songFilePath,
				'width'			=> 340,
				'height'		=> 80,
				'foreground'	=> "#8ee68c",
				'background'	=> "#FFFFFF",
				'draw_flat'		=> false,
				'detail'		=> 5,
				'is_stereo'		=> false
			));

			$imgMaker->process();

			if($imgMaker->saveAs($song->waveImageFilePath)) {
				$song->waveform_image = $song->waveImageFileName;
				$song->saveAttributes(array('waveform_image'));
			}

			unset($imgMaker);

		}
	}

}

?>