<?php

namespace PhpSigep\Cache\Storage\Adapter;

/**
 * These are options specific to the FileSystem adapter
 */
class FileSystemOptions extends AdapterOptions
{

    /**
     * Directory to store cache files
     *
     * @var null|string The cache directory
     *                  or NULL for the systems temporary directory
     */
    protected $cacheDir = null;

    /**
     * Call clearstatcache enabled?
     *
     * @var bool
     */
    protected $clearStatCache = true;

    /**
     * How much sub-directaries should be created?
     *
     * @var int
     */
    protected $dirLevel = 1;

    /**
     * Permission creating new directories
     *
     * @var false|int
     */
    protected $dirPermission = 0700;

    /**
     * Lock files on writing
     *
     * @var bool
     */
    protected $fileLocking = true;

    /**
     * Permission creating new files
     *
     * @var false|int
     */
    protected $filePermission = 0600;

    /**
     * Overwrite default key pattern
     *
     * Defined in AdapterOptions
     *
     * @var string
     */
    protected $keyPattern = '/^[a-z0-9_\+\-]*$/Di';

    /**
     * Namespace separator
     *
     * @var string
     */
    protected $namespaceSeparator = '-';

    /**
     * Umask to create files and directories
     *
     * @var false|int
     */
    protected $umask = false;

    /**
     * Constructor
     *
     * @param  array $options
     * @return FilesystemOptions
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($options = null)
    {
        // disable file/directory permissions by default on windows systems
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $this->filePermission = false;
            $this->dirPermission  = false;
        }

        parent::__construct($options);
    }

    /**
     * Set cache dir
     *
     * @param  string $cacheDir
     * @return FilesystemOptions
     * @throws Exception\InvalidArgumentException
     */
    public function setCacheDir($cacheDir)
    {
        if ($cacheDir !== null) {
            if (!is_dir($cacheDir)) {
                throw new Exception\InvalidArgumentException(
                    "Cache directory '{$cacheDir}' not found or not a directory"
                );
            } elseif (!is_writable($cacheDir)) {
                throw new Exception\InvalidArgumentException(
                    "Cache directory '{$cacheDir}' not writable"
                );
            } elseif (!is_readable($cacheDir)) {
                throw new Exception\InvalidArgumentException(
                    "Cache directory '{$cacheDir}' not readable"
                );
            }

            $cacheDir = rtrim(realpath($cacheDir), DIRECTORY_SEPARATOR);
        } else {
            $cacheDir = sys_get_temp_dir();
        }

        $this->cacheDir = $cacheDir;

        return $this;
    }

    /**
     * Get cache dir
     *
     * @return null|string
     */
    public function getCacheDir()
    {
        if ($this->cacheDir === null) {
            $this->setCacheDir(null);
        }

        return $this->cacheDir;
    }

    /**
     * Set clear stat cache
     *
     * @param  bool $clearStatCache
     * @return FilesystemOptions
     */
    public function setClearStatCache($clearStatCache)
    {
        $clearStatCache       = (bool)$clearStatCache;
        $this->clearStatCache = $clearStatCache;

        return $this;
    }

    /**
     * Get clear stat cache
     *
     * @return bool
     */
    public function getClearStatCache()
    {
        return $this->clearStatCache;
    }

    /**
     * Set dir level
     *
     * @param  int $dirLevel
     * @return FilesystemOptions
     * @throws Exception\InvalidArgumentException
     */
    public function setDirLevel($dirLevel)
    {
        $dirLevel = (int)$dirLevel;
        if ($dirLevel < 0 || $dirLevel > 16) {
            throw new Exception\InvalidArgumentException(
                "Directory level '{$dirLevel}' must be between 0 and 16"
            );
        }
        $this->dirLevel = $dirLevel;

        return $this;
    }

    /**
     * Get dir level
     *
     * @return int
     */
    public function getDirLevel()
    {
        return $this->dirLevel;
    }

    /**
     * Set permission to create directories on unix systems
     * @param false|string|int $dirPermission FALSE to disable explicit permission or an octal number
     * @throws Exception\InvalidArgumentException
     * @return FilesystemOptions
     * @see setUmask
     * @see setFilePermission
     * @link http://php.net/manual/function.chmod.php
     */
    public function setDirPermission($dirPermission)
    {
        if ($dirPermission !== false) {
            if (is_string($dirPermission)) {
                $dirPermission = octdec($dirPermission);
            } else {
                $dirPermission = (int)$dirPermission;
            }

            // validate
            if (($dirPermission & 0700) != 0700) {
                throw new Exception\InvalidArgumentException(
                    'Invalid directory permission: need permission to execute, read and write by owner'
                );
            }
        }

        if ($this->dirPermission !== $dirPermission) {
            $this->dirPermission = $dirPermission;
        }

        return $this;
    }

    /**
     * Get permission to create directories on unix systems
     *
     * @return false|int
     */
    public function getDirPermission()
    {
        return $this->dirPermission;
    }

    /**
     * Set file locking
     *
     * @param  bool $fileLocking
     * @return FilesystemOptions
     */
    public function setFileLocking($fileLocking)
    {
        $fileLocking       = (bool)$fileLocking;
        $this->fileLocking = $fileLocking;

        return $this;
    }

    /**
     * Get file locking
     *
     * @return bool
     */
    public function getFileLocking()
    {
        return $this->fileLocking;
    }

    /**
     * Set permission to create files on unix systems
     *
     * @param false|string|int $filePermission FALSE to disable explicit permission or an octal number
     * @throws Exception\InvalidArgumentException
     * @return FilesystemOptions
     * @see setUmask
     * @see setDirPermission
     * @link http://php.net/manual/function.chmod.php
     */
    public function setFilePermission($filePermission)
    {
        if ($filePermission !== false) {
            if (is_string($filePermission)) {
                $filePermission = octdec($filePermission);
            } else {
                $filePermission = (int)$filePermission;
            }

            // validate
            if (($filePermission & 0600) != 0600) {
                throw new Exception\InvalidArgumentException(
                    'Invalid file permission: need permission to read and write by owner'
                );
            } elseif ($filePermission & 0111) {
                throw new Exception\InvalidArgumentException(
                    "Invalid file permission: Cache files shoudn't be executable"
                );
            }
        }

        if ($this->filePermission !== $filePermission) {
            $this->filePermission = $filePermission;
        }

        return $this;
    }

    /**
     * Get permission to create files on unix systems
     *
     * @return false|int
     */
    public function getFilePermission()
    {
        return $this->filePermission;
    }

    /**
     * Set namespace separator
     *
     * @param  string $namespaceSeparator
     * @return FilesystemOptions
     */
    public function setNamespaceSeparator($namespaceSeparator)
    {
        $namespaceSeparator       = (string)$namespaceSeparator;
        $this->namespaceSeparator = $namespaceSeparator;

        return $this;
    }

    /**
     * Get namespace separator
     *
     * @return string
     */
    public function getNamespaceSeparator()
    {
        return $this->namespaceSeparator;
    }

    /**
     * Set the umask to create files and directories on unix systems
     *
     * Note: On multithreaded webservers it's better to explicit set file and dir permission.
     *
     * @param false|string|int $umask FALSE to disable umask or an octal number
     * @throws Exception\InvalidArgumentException
     * @return FilesystemOptions
     * @see setFilePermission
     * @see setDirPermission
     * @link http://php.net/manual/function.umask.php
     * @link http://en.wikipedia.org/wiki/Umask
     */
    public function setUmask($umask)
    {
        if ($umask !== false) {
            if (is_string($umask)) {
                $umask = octdec($umask);
            } else {
                $umask = (int)$umask;
            }

            // validate
            if ($umask & 0700) {
                throw new Exception\InvalidArgumentException(
                    'Invalid umask: need permission to execute, read and write by owner'
                );
            }

            // normalize
            $umask = $umask & 0777;
        }

        if ($this->umask !== $umask) {
            $this->umask = $umask;
        }

        return $this;
    }

    /**
     * Get the umask to create files and directories on unix systems
     *
     * @return false|int
     */
    public function getUmask()
    {
        return $this->umask;
    }
}
