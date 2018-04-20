<?php
/**
 *
 *
 *
 *
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
namespace machinebox\Test;

use PHPUnit\Framework\TestCase;

/**
 * Maschinebox.io Machinebox-Test
 */
final class ClassificationboxTest extends TestCase {
	
	public function test1() {
		$cb = new \machinebox\classificationbox("http://127.0.0.1:8081");
		$cb->createmodel("test1", "Classificationbox Test", array("blau", "rot", "gelb"));
		$this->assertTrue(true);
	}
	
}