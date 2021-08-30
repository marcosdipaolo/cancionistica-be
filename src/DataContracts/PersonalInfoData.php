<?php

namespace Cancionistica\DataContracts;

interface PersonalInfoData
{
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getPhonenumber(): string;
    public function getAddressLineOne(): string | null;
    public function getAddressLineTwo(): string | null;
    public function getPostcode(): string | null;
    public function getCity(): string | null;
    public function getCountry(): string | null;
}
