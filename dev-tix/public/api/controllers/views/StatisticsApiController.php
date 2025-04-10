<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class StatisticsApiController extends AbsApiController
{
    public function get()
    {
        $return = [
            'role' => $this->extractRoleData(),
            'age' => $this->extractAgeData(),
            'gender' => $this->extractGenderData(),
            'profession' => $this->extractProfessionData(),
        ];

        return ApiMessage::dataFetchAttempt($return);
    }

    private function extractRoleData()
    {
        return [
            'administrator' => $this->getTotalUsersPerRole(1),
            'assistant' => $this->getTotalUsersPerRole(2),
            'patron' => $this->getTotalUsersPerRole(3)
        ];
    }

    private function getTotalUsersPerRole(int $roleID)
    {
        $query = 'SELECT COUNT(user_id) AS total FROM users WHERE role_id = :role_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':role_id' => $roleID]
        )->getQueryResult()['total'];
    }

    private function extractAgeData()
    {
        return [
            '18-24' => $this->getTotalUserPerAge(18, 24),
            '25-32' => $this->getTotalUserPerAge(25, 32),
            '33-41' => $this->getTotalUserPerAge(33, 41),
            '42-51' => $this->getTotalUserPerAge(42, 51),
            '52-64' => $this->getTotalUserPerAge(52, 64),
            '65+' => $this->getTotalUserPerAge(65, 100)
        ];
    }

    private function getTotalUserPerAge(int $minAge, int $maxAge)
    {
        $query = 'SELECT COUNT(user_id) AS total FROM user_details WHERE age >= :min AND age <= :max;';
        return Session::getDbInstance()->executeQuery(
            $query, [':min' => $minAge, ':max' => $maxAge]
        )->getQueryResult()['total'];
    }

    private function extractGenderData()
    {
        return [
            'male' => $this->getTotalUsersPerGender('male'),
            'female' => $this->getTotalUsersPerGender('female')
        ];
    }

    private function getTotalUsersPerGender(string $gender)
    {
        $query = 'SELECT COUNT(user_id) AS total FROM user_details WHERE gender = :gender;';
        return Session::getDbInstance()->executeQuery(
            $query, [':gender' => $gender]
        )->getQueryResult()['total'];
    }

    private function extractProfessionData()
    {
        return [
            'frontend-developer' => $this->getTotalUsersPerProfession('frontend-developer'),
            'backend-developer' => $this->getTotalUsersPerProfession('backend-developer'),
            'fullStack-developer' => $this->getTotalUsersPerProfession('fullStack-developer'),
            'software-engineer' => $this->getTotalUsersPerProfession('software-engineer'),
            'devOps-engineer' => $this->getTotalUsersPerProfession('devOps-engineer'),
            'data-analyst' => $this->getTotalUsersPerProfession('data-analyst'),
            'project-manager' => $this->getTotalUsersPerProfession('project-manager'),
            'other' => $this->getTotalUsersPerProfession('other'),
        ];
    }

    private function getTotalUsersPerProfession(string $profession)
    {
        $query = 'SELECT COUNT(user_id) AS total FROM user_details WHERE profession = :profession;';
        return Session::getDbInstance()->executeQuery(
            $query, [':profession' => $profession]
        )->getQueryResult()['total'];
    }
}
