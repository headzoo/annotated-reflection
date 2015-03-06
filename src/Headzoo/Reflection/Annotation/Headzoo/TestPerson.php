<?php
namespace Headzoo\Reflection\Annotation\Headzoo;

/**
 * @Annotation
 * 
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class TestPerson
    extends AbstractAnnotation
{
    /**
     * @var string
     */
    protected $job;

    /**
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param string $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }
}