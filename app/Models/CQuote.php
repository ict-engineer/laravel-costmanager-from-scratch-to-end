<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CQuote extends Model
{
    //
    protected $table = 'cquotes';

    protected $fillable = [
        'project_id', 'discount', 'total', 'status', 'unprevented', 'advance', 'shopdays', 'quote_number', 'invoice_number', 'isInvoice', 'isQuote', 'invoice_status',
    ];

    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }

    public function quotegroups()
    {
    	return $this->belongsTo('App\Models\QuoteGroup');
    }

    public function quotecomments()
    {
    	return $this->belongsTo('App\Models\QuoteComment');
    }

    public function quoteservices()
    {
    	return $this->belongsTo('App\Models\QuoteService');
    }

    public function quoteemployees()
    {
    	return $this->belongsTo('App\Models\QuoteEmployee');
    }
}
