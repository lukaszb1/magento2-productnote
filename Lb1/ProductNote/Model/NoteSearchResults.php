<?php declare(strict_types=1);

namespace Lb1\ProductNote\Model;

use Lb1\ProductNote\Api\Data\NoteSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class NoteSearchResults
    extends SearchResults
    implements NoteSearchResultsInterface
{}
