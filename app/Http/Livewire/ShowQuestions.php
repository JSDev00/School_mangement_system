<?php

namespace App\Http\Livewire;

use App\Models\Question;
use App\Models\Degree;
use Livewire\Component;

class ShowQuestions extends Component
{
    public $quizz_id,$student_id,$data,$counter = 0,$questionCount = 0;

    public function render()
    {
        $this->data = Question::where('quizze_id',$this->quizz_id)->get();
        $this->questionCount = $this->data->count();
        return view('livewire.show-questions',['data']);
    }
    public function nextQuestion($question_id,$score,$answer,$right_answer){

        $stdDegree = Degree::where('student_id',$this->student_id)->where('quizze_id',$this->quizz_id)->first();

        if($stdDegree == null){
            $degree = new Degree();
            $degree->student_id = $this->student_id;
            $degree->quizze_id = $this->quizz_id;
            $degree->question_id = $question_id;
            if (strcmp(trim($answer), trim($right_answer)) === 0) {
                $degree->score += $score;
            } else {
                $degree->score += 0;
            }
            $degree->date = date('Y-m-d');
            $degree->save();

        }else{
            if ($stdDegree->question_id >= $this->data[$this->counter]->id) {
                $stdDegree->score = 0;
                $stdDegree->abuse = '1';
                $stdDegree->save();
                toastr()->error('تم إلغاء الاختبار لإكتشاف تلاعب بالنظام');
                return redirect('student_exam');
            }else{
                $stdDegree->question_id = $question_id;
                if (strcmp(trim($answer), trim($right_answer)) === 0) {
                    $stdDegree->score += $score;
                } else {
                    $stdDegree->score += 0;
                }
                $stdDegree->save();
            }

        }

        if($this->counter < $this->questionCount-1){
            $this->counter++;
        }else {
            toastr()->success('تم إجراء الاختبار بنجاح');
            return redirect('student_exam');
        }
    }
}
