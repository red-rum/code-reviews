<?php
class ControllerFunction 
{

    public function getNewsletters()
    {
        $current_year = date("Y");

        if(!Input::get('start_date') && !Input::get('end_date'))
        {
            return redirect('employee-central/employee-newsletter/' . $current_year);
        }

        // Perhaps add in some check for filter
        $newsletters = Newsletter::published()
            ->isActive();

        $years = Newsletter::published()
            ->isActive()
            ->select(DB::raw('YEAR(created_at) year'))
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->get();

        $date_range = '';

        if(Input::get('start_date') && Input::get('end_date'))
        {
            $start_date = Carbon::createFromFormat('d/m/Y', Input::get('start_date'), 'Europe/London');
            $end_date = Carbon::createFromFormat('d/m/Y', Input::get('end_date'), 'Europe/London');

            $newsletters = $newsletters->
                whereBetween('date', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"]);

            $date_range = 'from: ' . Input::get('start_date') . ' to: ' . Input::get('end_date');
        }
        else
        {
            if(Input::get('start_date'))
            {
                $date_range .= 'from: ' . Input::get('start_date') . ' ';
                $newsletters = $newsletters->whereDate('date', '>=', Input::get('start_date'));
            }

            if(Input::get('end_date'))
            {
                $date_range .= 'to: ' . Input::get('end_date');
                $newsletters = $newsletters->whereDate('date', '<=', Input::get('end_date'));
            }
        }

        $newsletters = $newsletters->orderBy('date', 'desc');
        $newsletters = $newsletters->get();

        return view('content.employee-central.employee-newsletters.employee-newsletter-search-results', compact('newsletters', 'current_year', 'years', 'date_range'));
    }
}
