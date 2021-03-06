<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ContactBundle\Api;

use Sulu\Bundle\CategoryBundle\Api\Category;
use Sulu\Bundle\ContactBundle\Entity\AccountAddress as AccountAddressEntity;
use Sulu\Bundle\ContactBundle\Entity\AccountAddress;
use Sulu\Bundle\ContactBundle\Entity\AccountContact as AccountContactEntity;
use Sulu\Bundle\ContactBundle\Entity\AccountInterface;
use Sulu\Bundle\ContactBundle\Entity\BankAccount as BankAccountEntity;
use Sulu\Bundle\ContactBundle\Entity\Contact as ContactEntity;
use Sulu\Bundle\ContactBundle\Entity\ContactAddress;
use Sulu\Bundle\ContactBundle\Entity\Email as EmailEntity;
use Sulu\Bundle\ContactBundle\Entity\Fax as FaxEntity;
use Sulu\Bundle\ContactBundle\Entity\Note as NoteEntity;
use Sulu\Bundle\ContactBundle\Entity\Phone as PhoneEntity;
use Sulu\Bundle\ContactBundle\Entity\Url as UrlEntity;
use Sulu\Bundle\MediaBundle\Api\Media;
use Sulu\Bundle\MediaBundle\Entity\Media as MediaEntity;
use Sulu\Bundle\TagBundle\Entity\Tag as TagEntity;
use Sulu\Component\Rest\ApiWrapper;
use Hateoas\Configuration\Annotation\Relation;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Groups;

/**
 * The Account class which will be exported to the API
 *
 * @package Sulu\Bundle\ContactBundle\Api
 * @Relation("self", href="expr('/api/admin/accounts/' ~ object.getId())")
 * @ExclusionPolicy("all")
 */
class Account extends ApiWrapper
{
    /**
     * @param AccountInterface $account
     * @param string $locale The locale of this product
     */
    public function __construct(AccountInterface $account, $locale)
    {
        $this->entity = $account;
        $this->locale = $locale;
    }

    /**
     * Returns the id of the product
     *
     * @return int
     * @VirtualProperty
     * @SerializedName("id")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getId()
    {
        return $this->entity->getId();
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Account
     */
    public function setLft($lft)
    {
        $this->entity->setLft($lft);

        return $this;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Account
     */
    public function setRgt($rgt)
    {
        $this->entity->setRgt($rgt);

        return $this;
    }

    /**
     * Set depth
     *
     * @param integer $depth
     * @return Account
     */
    public function setDepth($depth)
    {
        $this->entity->setDepth($depth);

        return $this;
    }

    /**
     * Get depth
     *
     * @return integer
     * @VirtualProperty
     * @SerializedName("depth")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getDepth()
    {
        return $this->entity->getDepth();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Account
     */
    public function setName($name)
    {
        $this->entity->setName($name);

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("name")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getName()
    {
        return $this->entity->getName();
    }

    /**
     * Get created
     *
     * @return \DateTime
     * @VirtualProperty
     * @SerializedName("created")
     * @Groups({"fullAccount"})
     */
    public function getCreated()
    {
        return $this->entity->getCreated();
    }

    /**
     * Get changed
     *
     * @return \DateTime
     * @VirtualProperty
     * @SerializedName("changed")
     * @Groups({"fullAccount"})
     */
    public function getChanged()
    {
        return $this->entity->getChanged();
    }

    /**
     * Set parent
     *
     * @param AccountInterface $parent
     * @return Account
     */
    public function setParent(AccountInterface $parent = null)
    {
        $this->entity->setParent($parent);

        return $this;
    }

    /**
     * Get parent
     *
     * @return AccountInterface
     * @VirtualProperty
     * @SerializedName("parent")
     * @Groups({"fullAccount"})
     */
    public function getParent()
    {
        $account = $this->entity->getParent();
        if ($account) {
            return new Account($account, $this->locale);
        }

        return null;
    }

    /**
     * Add urls
     *
     * @param UrlEntity $url
     * @return Account
     */
    public function addUrl(UrlEntity $url)
    {
        $this->entity->addUrl($url);

        return $this;
    }

    /**
     * Remove urls
     *
     * @param UrlEntity $url
     */
    public function removeUrl(UrlEntity $url)
    {
        $this->entity->removeUrl($url);
    }

    /**
     * Get urls
     *
     * @return UrlEntity[]
     * @VirtualProperty
     * @SerializedName("urls")
     * @Groups({"fullAccount"})
     */
    public function getUrls()
    {
        $urls = array();
        if ($this->entity->getUrls()) {
            foreach ($this->entity->getUrls() as $url) {
                $urls[] = $url;
            }
        }

        return $urls;
    }

    /**
     * Add phones
     *
     * @param PhoneEntity $phones
     * @return Account
     */
    public function addPhone(PhoneEntity $phones)
    {
        $this->entity->addPhone($phones);

        return $this;
    }

    /**
     * Remove phones
     *
     * @param PhoneEntity $phone
     */
    public function removePhone(PhoneEntity $phone)
    {
        $this->entity->removePhone($phone);
    }

    /**
     * Get phones
     *
     * @return PhoneEntity[]
     * @VirtualProperty
     * @SerializedName("phones")
     * @Groups({"fullAccount"})
     */
    public function getPhones()
    {
        $phones = array();
        if ($this->entity->getPhones()) {
            foreach ($this->entity->getPhones() as $phone) {
                $phones[] = $phone;
            }
        }

        return $phones;
    }

    /**
     * Add emails
     *
     * @param EmailEntity $email
     * @return Account
     */
    public function addEmail(EmailEntity $email)
    {
        $this->entity->addEmail($email);

        return $this;
    }

    /**
     * Remove emails
     *
     * @param EmailEntity $email
     */
    public function removeEmail(EmailEntity $email)
    {
        $this->entity->removeEmail($email);
    }

    /**
     * Get emails
     *
     * @return EmailEntity[]
     * @VirtualProperty
     * @SerializedName("emails")
     * @Groups({"fullAccount"})
     */
    public function getEmails()
    {
        $emails = array();
        if ($this->entity->getEmails()) {
            foreach ($this->entity->getEmails() as $email) {
                $emails[] = $email;
            }
        }

        return $emails;
    }

    /**
     * Add notes
     *
     * @param NoteEntity $notes
     * @return Account
     */
    public function addNote(NoteEntity $notes)
    {
        $this->entity->addNote($notes);

        return $this;
    }

    /**
     * Remove notes
     *
     * @param NoteEntity $note
     */
    public function removeNote(NoteEntity $note)
    {
        $this->entity->removeNote($note);
    }

    /**
     * Get notes
     *
     * @return NoteEntity[]
     * @VirtualProperty
     * @SerializedName("notes")
     * @Groups({"fullAccount"})
     */
    public function getNotes()
    {
        $notes = array();
        if ($this->entity->getNotes()) {
            foreach ($this->entity->getNotes() as $note) {
                $notes[] = $note;
            }
        }

        return $notes;
    }

    /**
     * Add faxes
     *
     * @param FaxEntity $fax
     * @return Account
     */
    public function addFax(FaxEntity $fax)
    {
        $this->entity->addFax($fax);

        return $this;
    }

    /**
     * Remove faxes
     *
     * @param FaxEntity $fax
     */
    public function removeFax(FaxEntity $fax)
    {
        $this->entity->removeFax($fax);
    }

    /**
     * Get faxes
     *
     * @return FaxEntity[]
     * @VirtualProperty
     * @SerializedName("faxes")
     * @Groups({"fullAccount"})
     */
    public function getFaxes()
    {
        $faxes = array();
        if ($this->entity->getFaxes()) {
            foreach ($this->entity->getFaxes() as $fax) {
                $faxes[] = $fax;
            }
        }

        return $faxes;
    }

    /**
     * Set corporation
     *
     * @param string $corporation
     * @return Account
     */
    public function setCorporation($corporation)
    {
        $this->entity->setCorporation($corporation);

        return $this;
    }

    /**
     * Get corporation
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("corporation")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getCorporation()
    {
        return $this->entity->getCorporation();
    }

    /**
     * Set disabled
     *
     * @param integer $disabled
     * @return Account
     */
    public function setDisabled($disabled)
    {
        $this->entity->setDisabled($disabled);

        return $this;
    }

    /**
     * Get disabled
     *
     * @return integer
     * @VirtualProperty
     * @SerializedName("disabled")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getDisabled()
    {
        return $this->entity->getDisabled();
    }

    /**
     * Set uid
     *
     * @param string $uid
     * @return Account
     */
    public function setUid($uid)
    {
        $this->entity->setUid($uid);

        return $this;
    }

    /**
     * Get uid
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("uid")
     * @Groups({"fullAccount"})
     */
    public function getUid()
    {
        return $this->entity->getUid();
    }

    /**
     * Add faxes
     *
     * @param FaxEntity $fax
     * @return Account
     */
    public function addFaxe(FaxEntity $fax)
    {
        $this->entity->addFaxe($fax);

        return $this;
    }

    /**
     * Remove faxes
     *
     * @param FaxEntity $fax
     * @return Account
     */
    public function removeFaxe(FaxEntity $fax)
    {
        $this->entity->removeFaxe($fax);
    }

    /**
     * Set registerNumber
     *
     * @param string $registerNumber
     * @return Account
     */
    public function setRegisterNumber($registerNumber)
    {
        $this->entity->setRegisterNumber($registerNumber);

        return $this;
    }

    /**
     * Get registerNumber
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("registerNumber")
     * @Groups({"fullAccount"})
     */
    public function getRegisterNumber()
    {
        return $this->entity->getRegisterNumber();
    }

    /**
     * Add bankAccounts
     *
     * @param BankAccountEntity $bankAccount
     * @return Account
     */
    public function addBankAccount(BankAccountEntity $bankAccount)
    {
        $this->entity->addBankAccount($bankAccount);

        return $this;
    }

    /**
     * Remove bankAccounts
     *
     * @param BankAccountEntity $bankAccount
     */
    public function removeBankAccount(BankAccountEntity $bankAccount)
    {
        $this->entity->removeBankAccount($bankAccount);
    }

    /**
     * Get bankAccounts
     *
     * @return BankAccountEntity[]
     * @VirtualProperty
     * @SerializedName("bankAccounts")
     * @Groups({"fullAccount"})
     */
    public function getBankAccounts()
    {
        $bankAccounts = array();
        if ($this->entity->getBankAccounts()) {
            foreach ($this->entity->getBankAccounts() as $bankAccount) {
                /** @var BankAccountEntity $bankAccount */
                $bankAccounts[] = new BankAccount($bankAccount);
            }
        }

        return $bankAccounts;
    }

    /**
     * Add tags
     *
     * @param TagEntity $tag
     * @return Account
     */
    public function addTag(TagEntity $tag)
    {
        $this->entity->addTag($tag);

        return $this;
    }

    /**
     * Remove tags
     *
     * @param TagEntity $tag
     */
    public function removeTag(TagEntity $tag)
    {
        $this->entity->removeTag($tag);
    }

    /**
     * Get tags
     *
     * @return TagEntity[]
     * @VirtualProperty
     * @SerializedName("tags")
     * @Groups({"fullAccount"})
     */
    public function getTags()
    {
        return $this->entity->getTagNameArray();
    }

    /**
     * Add accountContacts
     *
     * @param AccountContactEntity $accountContact
     * @return Account
     */
    public function addAccountContact(AccountContactEntity $accountContact)
    {
        $this->entity->addAccountContact($accountContact);

        return $this;
    }

    /**
     * Remove accountContacts
     *
     * @param AccountContactEntity $accountContact
     */
    public function removeAccountContact(AccountContactEntity $accountContact)
    {
        $this->entity->removeAccountContact($accountContact);
    }

    /**
     * Get accountContacts
     *
     * @return AccountContact[]
     * @VirtualProperty
     * @SerializedName("accountContacts")
     * @Groups({"fullAccount"})
     */
    public function getAccountContacts()
    {
        $accountContacts = array();
        if ($this->entity->getAccountContacts()) {
            foreach ($this->entity->getAccountContacts() as $AccountContact) {
                $accountContacts[] = new AccountContact($AccountContact, $this->locale);
            }
        }

        return $accountContacts;
    }

    /**
     * Set placeOfJurisdiction
     *
     * @param string $placeOfJurisdiction
     * @return Account
     */
    public function setPlaceOfJurisdiction($placeOfJurisdiction)
    {
        $this->entity->setPlaceOfJurisdiction($placeOfJurisdiction);

        return $this;
    }

    /**
     * Get placeOfJurisdiction
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("placeOfJurisdiction")
     * @Groups({"fullAccount"})
     */
    public function getPlaceOfJurisdiction()
    {
        return $this->entity->getPlaceOfJurisdiction();
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Account
     */
    public function setNumber($number)
    {
        $this->entity->setNumber($number);

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("number")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getNumber()
    {
        return $this->entity->getNumber();
    }

    /**
     * Set externalId
     *
     * @param string $externalId
     * @return Account
     */
    public function setExternalId($externalId)
    {
        $this->entity->setExternalId($externalId);

        return $this;
    }

    /**
     * Get externalId
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("externalId")
     * @Groups({"fullAccount"})
     */
    public function getExternalId()
    {
        return $this->entity->GetExternalId();
    }

    /**
     * Set mainContact
     *
     * @param ContactEntity $mainContact
     * @return Account
     */
    public function setMainContact(ContactEntity $mainContact = null)
    {
        $this->entity->setMainContact($mainContact);

        return $this;
    }

    /**
     * Get mainContact
     *
     * @return Account
     * @VirtualProperty
     * @SerializedName("mainContact")
     * @Groups({"fullAccount"})
     */
    public function getMainContact()
    {
        if ($this->entity->getMainContact()) {
            return new Contact($this->entity->getMainContact(), $this->locale);
        }
    }

    /**
     * Set mainEmail
     *
     * @param string $mainEmail
     * @return Account
     */
    public function setMainEmail($mainEmail)
    {
        $this->entity->setMainEmail($mainEmail);

        return $this;
    }

    /**
     * Get mainEmail
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("mainEmail")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getMainEmail()
    {
        return $this->entity->getMainEmail();
    }

    /**
     * Set mainPhone
     *
     * @param string $mainPhone
     * @return Account
     */
    public function setMainPhone($mainPhone)
    {
        $this->entity->setMainPhone($mainPhone);

        return $this;
    }

    /**
     * Get mainPhone
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("mainPhone")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getMainPhone()
    {
        return $this->entity->getMainPhone();
    }

    /**
     * Set mainFax
     *
     * @param string $mainFax
     * @return Account
     */
    public function setMainFax($mainFax)
    {
        $this->entity->setMainFax($mainFax);

        return $this;
    }

    /**
     * Get mainFax
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("mainFax")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getMainFax()
    {
        return $this->entity->getMainFax();
    }

    /**
     * Set mainUrl
     *
     * @param string $mainUrl
     * @return Account
     */
    public function setMainUrl($mainUrl)
    {
        $this->entity->setMainUrl($mainUrl);

        return $this;
    }

    /**
     * Get mainUrl
     *
     * @return string
     * @VirtualProperty
     * @SerializedName("mainUrl")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getMainUrl()
    {
        return $this->entity->getMainUrl();
    }

    /**
     * Add accountAddresses
     *
     * @param AccountAddressEntity $accountAddress
     * @return Account
     */
    public function addAccountAddresse(AccountAddressEntity $accountAddress)
    {
        $this->entity->addAccountAddresse($accountAddress);

        return $this;
    }

    /**
     * Remove accountAddresses
     *
     * @param AccountAddressEntity $accountAddresses
     */
    public function removeAccountAddresse(AccountAddressEntity $accountAddresses)
    {
        $this->entity->removeAccountAddresse($accountAddresses);
    }

    /**
     * Get accountAddresses
     *
     * @return AccountAddressEntity[]
     * @VirtualProperty
     * @SerializedName("accountAddresses")
     */
    public function getAccountAddresses()
    {
        $accountAddresses = array();
        if ($this->entity->getAccountAddresses()) {
            foreach ($this->entity->getAccountAddresses() as $adr) {
                $accountAddress[] = new AccountAddress($adr);
            }
        }

        return $accountAddresses;
    }

    /**
     * returns addresses
     *
     * @VirtualProperty
     * @SerializedName("addresses")
     * @Groups({"fullAccount"})
     */
    public function getAddresses()
    {
        $accountAddresses = $this->entity->getAccountAddresses();
        $addresses = array();

        if (!is_null($accountAddresses)) {
            /** @var ContactAddress $accountAddress */
            foreach ($accountAddresses as $accountAddress) {
                $address = $accountAddress->getAddress();
                $address->setPrimaryAddress($accountAddress->getMain());
                $addresses[] = $address;
            }
        }

        return $addresses;
    }

    /**
     * Returns the main address
     *
     * @return mixed
     * @VirtualProperty
     * @SerializedName("mainAddress")
     * @Groups({"fullAccount", "partialAccount"})
     */
    public function getMainAddress()
    {
        $accountAddresses = $this->entity->getAccountAddresses();

        if (!is_null($accountAddresses)) {
            /** @var AccountAddressEntity $accountAddress */
            foreach ($accountAddresses as $accountAddress) {
                if ($accountAddress->getMain()) {
                    return $accountAddress->getAddress();
                }
            }
        }

        return null;
    }

    /**
     * Get contacts
     *
     * @return Contact[]
     * @VirtualProperty
     * @SerializedName("contacts")
     * @Groups({"fullAccount"})
     */
    public function getContacts()
    {
        $accountContacts = $this->entity->getAccountContacts();
        $contacts = array();

        if (!is_null($accountContacts)) {
            /** @var AccountContactEntity $accountContact */
            foreach ($accountContacts as $accountContact) {
                $contacts[] = new Contact($accountContact->getContact(), $this->locale);
                $contacts[] = new Contact($accountContact->getContact(), $this->locale);
            }
        }

        return $contacts;
    }

    /**
     * Add medias
     *
     * @param MediaEntity $medias
     * @return Account
     */
    public function addMedia(MediaEntity $medias)
    {
        $this->entity->addMedia($medias);

        return $this;
    }

    /**
     * Remove medias
     *
     * @param MediaEntity $medias
     */
    public function removeMedia(MediaEntity $medias)
    {
        $this->entity->removeMedia($medias);
    }

    /**
     * Get medias
     *
     * @return Media[]
     * @VirtualProperty
     * @SerializedName("medias")
     * @Groups({"fullAccount"})
     */
    public function getMedias()
    {
        $medias = array();
        if ($this->entity->getMedias()) {
            foreach ($this->entity->getMedias() as $media) {
                $medias[] = new Media($media, $this->locale, null);
            }
        }

        return $medias;
    }

    /**
     * Get categories
     *
     * @return Category[]
     * @VirtualProperty
     * @SerializedName("categories")
     * @Groups({"fullAccount"})
     */
    public function getCategories()
    {
        $entities = array();
        if ($this->entity->getCategories()) {
            foreach ($this->entity->getCategories() as $category) {
                $entities[] = new Category($category, $this->locale);
            }
        }

        return $entities;
    }
}
