<?php

namespace Workdo\ActivityLog\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;

use Workdo\Rotas\Events\AddDayoff;
use Workdo\School\Events\AdmissionConvert;
use Workdo\Appointment\Events\AppointmentStatus;
use Workdo\VCard\Events\BusinessStatus;
use Workdo\CleaningManagement\Events\ChangeStatusCleaningBookingRequest;
use Workdo\Newspaper\Events\ChangeStatusNewspaperInvoice;
use App\Events\CompanyMenuEvent;
use Workdo\Recruitment\Events\ConvertToEmployee;
use App\Events\ConvertToInvoice;
use Workdo\Contract\Events\CopyContract;
use Workdo\CourierManagement\Events\Couriercreate;
use Workdo\CourierManagement\Events\Courierupdate;
use Workdo\FixEquipment\Events\CreateAccessories;
use Workdo\School\Events\CreateAdmission;
use Workdo\LegalCaseManagement\Events\CreateAdvocate;
use Workdo\AgricultureManagement\Events\CreateAgricultureActivities;
use Workdo\AgricultureManagement\Events\CreateAgricultureCanal;
use Workdo\AgricultureManagement\Events\CreateAgricultureClaimType;
use Workdo\AgricultureManagement\Events\CreateAgricultureCrop;
use Workdo\AgricultureManagement\Events\CreateAgricultureCultivation;
use Workdo\AgricultureManagement\Events\CreateAgricultureCycles;
use Workdo\AgricultureManagement\Events\CreateAgricultureDepartment;
use Workdo\AgricultureManagement\Events\CreateAgricultureEquipment;
use Workdo\AgricultureManagement\Events\CreateAgricultureOffices;
use Workdo\AgricultureManagement\Events\CreateAgricultureProcess;
use Workdo\AgricultureManagement\Events\CreateAgricultureSeason;
use Workdo\AgricultureManagement\Events\CreateAgricultureSeasonType;
use Workdo\AgricultureManagement\Events\CreateAgricultureServiceProduct;
use Workdo\AgricultureManagement\Events\CreateAgricultureServices;
use Workdo\AgricultureManagement\Events\CreateAgricultureUser;
use Workdo\AgricultureManagement\Events\CreateAgriculturefleet;
use Workdo\Hrm\Events\CreateAllowance;
use Workdo\DairyCattleManagement\Events\CreateAnimal;
use Workdo\Hrm\Events\CreateAnnouncement;
use Workdo\Appointment\Events\CreateAppointment;
use Workdo\Appointment\Events\CreateAppointments;
use Workdo\Performance\Events\CreateAppraisal;
use Workdo\Internalknowledge\Events\CreateArticle;
use Workdo\FixEquipment\Events\CreateAsset;
use Workdo\Assets\Events\CreateAssets;
use Workdo\FixEquipment\Events\CreateAudit;
use Workdo\Rotas\Events\CreateAvailability;
use Workdo\Hrm\Events\CreateAward;
use Workdo\Account\Events\CreateBankAccount;
use Workdo\Account\Events\CreateBankTransfer;
use Workdo\BeautySpaManagement\Events\CreateBeautyBooking;
use Workdo\BeautySpaManagement\Events\CreateBeautyService;
use Workdo\Account\Events\CreateBill;
use Workdo\BeverageManagement\Events\CreateBillOfMaterial;
use Workdo\LMS\Events\CreateBlog;
use Workdo\Internalknowledge\Events\CreateBook;
use Workdo\Holidayz\Events\CreateBookingCoupon;
use Workdo\Fleet\Events\CreateBooking;
use Workdo\Bookings\Events\CreateBookingsAppointment;
use Workdo\Bookings\Events\CreateBookingsCustomer;
use Workdo\Bookings\Events\CreateBookingsPackage;
use Workdo\Bookings\Events\CreateBookingsStaff;
use Workdo\DairyCattleManagement\Events\CreateBreeding;
use Workdo\Taskly\Events\CreateBug;
use Workdo\VCard\Events\CreateBusiness;
use Workdo\BusinessModel\Events\CreateBusinessModel;
use Workdo\BusinessPlan\Events\CreateBusinessPlan;
use Workdo\BusinessProcessMapping\Events\CreateBusinessProcessMapping;
use Workdo\Sales\Events\CreateCall;
use Workdo\CallHub\Events\CreateCallList;
use Workdo\CallHub\Events\CreateCallhubAdavance;
use Workdo\CarDealership\Events\CreateCarPurchase;
use Workdo\CarDealership\Events\CreateCarSale;
use Workdo\LegalCaseManagement\Events\CreateCaseInitiator;
use Workdo\LegalCaseManagement\Events\CreateCase;
use Workdo\CateringManagement\Events\CreateCateringCustomer;
use Workdo\CateringManagement\Events\CreateCateringInvoice;
use Workdo\InnovationCenter\Events\CreateChallenge;
use Workdo\Sales\Events\CreateChangeOrder;
use Workdo\Planning\Events\CreateCharter;
use Workdo\ChildcareManagement\Events\CreateChildAttendance;
use Workdo\ChildcareManagement\Events\CreateChild;
use Workdo\School\Events\CreateClassroom;
use Workdo\CleaningManagement\Events\CreateCleaningBooking;
use Workdo\CleaningManagement\Events\CreateCleaningTeam;
use Workdo\CMMS\Events\CreateCmmspos;
use Workdo\BeverageManagement\Events\CreateCollectionCenter;
use Workdo\Hrm\Events\CreateCommission;
use Workdo\Commission\Events\CreateCommissionPlan;
use Workdo\Commission\Events\CreateCommissionReceipt;
use Workdo\Sales\Events\CreateCommonCase;
use Workdo\Hrm\Events\CreateCompanyPolicy;
use Workdo\Hrm\Events\CreateComplaint;
use Workdo\CMMS\Events\CreateComponent;
use Workdo\ConsignmentManagement\Events\CreateConsignment;
use Workdo\ConsignmentManagement\Events\CreateProduct as CreateConsignmentProduct;
use Workdo\FixEquipment\Events\CreateConsumables;
use Workdo\Sales\Events\CreateContact;
use Workdo\Contract\Events\CreateContract;
use Workdo\LMS\Events\CreateCourseCoupon;
use Workdo\LMS\Events\CreateCourse;
use Workdo\LegalCaseManagement\Events\CreateCourt;
use Workdo\InnovationCenter\Events\CreateCreativity;
use Workdo\CustomField\Events\CreateCustomField;
use Workdo\LMS\Events\CreateCustomPage;
use Workdo\Recruitment\Events\CreateCustomQuestion;
use Workdo\Account\Events\CreateCustomer;
use Workdo\DairyCattleManagement\Events\CreateDailyMilkSheet;
use Workdo\Lead\Events\CreateDeal;
use Workdo\Lead\Events\CreateDealTask;
use Workdo\CarDealership\Events\CreateDealershipProduct;
use Workdo\VehicleInspectionManagement\Events\CreateDefectsAndRepairs;
use Workdo\MachineRepairManagement\Events\CreateDiagnosis;
use Workdo\RestaurantMenu\Events\CreateDiningTable;
use Workdo\LegalCaseManagement\Events\CreateDivision;
use Workdo\HospitalManagement\Events\CreateDoctor;
use Workdo\Hrm\Events\CreateDocument;
use Workdo\PropertyManagement\Events\CreateDocumentType;
use Workdo\Fleet\Events\CreateDriver;
use Workdo\DrivingSchool\Events\CreateDrivingClass;
use Workdo\DrivingSchool\Events\CreateDrivingInvoice;
use Workdo\DrivingSchool\Events\CreateDrivingStudent;
use Workdo\DrivingSchool\Events\CreateDrivingVehicle;
use Workdo\Hrm\Events\CreateEmployee;
use Workdo\CateringManagement\Events\CreateEventDetail;
use Workdo\Hrm\Events\CreateEvent;
use Workdo\LegalCaseManagement\Events\CreateExpense;
use Workdo\ChildcareManagement\Events\CreateFee;
use Workdo\LegalCaseManagement\Events\CreateFeeReciept;
use Workdo\LegalCaseManagement\Events\CreateFeeRecieve;
use Workdo\FileSharing\Events\CreateFile;
use Workdo\Goal\Events\CreateFinacialGoal;
use Workdo\FixEquipment\Events\CreateComponent as CreateFixComponent;
use Workdo\Fleet\Events\CreateFleetCustomer;
use Workdo\FormBuilder\Events\CreateFormField;
use Workdo\FormBuilder\Events\CreateForm;
use Workdo\FreightManagementSystem\Events\CreateFreightBookingRequest;
use Workdo\FreightManagementSystem\Events\CreateFreightCustomer;
use Workdo\Fleet\Events\CreateFuel;
use Workdo\GarageManagement\Events\CreateGarageVehicle;
use Workdo\Performance\Events\CreateGoalTracking;
use Workdo\GymManagement\Events\CreateGymMember;
use Workdo\GymManagement\Events\CreateGymTrainer;
use Workdo\DairyCattleManagement\Events\CreateHealth;
use Workdo\LegalCaseManagement\Events\CreateHighCourt;
use Workdo\Hrm\Events\CreateHolidays;
use Workdo\HospitalManagement\Events\CreateHospitalAppointment;
use Workdo\HospitalManagement\Events\CreateHospitalBed;
use Workdo\HospitalManagement\Events\CreateHospitalMedicine;
use Workdo\Holidayz\Events\CreateHotelCustomer;
use Workdo\Holidayz\Events\CreateHotelService;
use Workdo\Performance\Events\CreateIndicator;
use Workdo\ChildcareManagement\Events\CreateInquiry;
use Workdo\VehicleInspectionManagement\Events\CreateInspectionList;
use Workdo\VehicleInspectionManagement\Events\CreateInspectionRequest;
use Workdo\VehicleInspectionManagement\Events\CreateInspectionVehicle;
use Workdo\Fleet\Events\CreateInsurance;
use Workdo\Recruitment\Events\CreateInterviewSchedule;
use App\Events\CreateInvoice;
use Workdo\Recruitment\Events\CreateJobApplicationStageChange;
use Workdo\Recruitment\Events\CreateJobApplication;
use Workdo\Recruitment\Events\CreateJobBoard;
use Workdo\Recruitment\Events\CreateJobCandidate;
use Workdo\Recruitment\Events\CreateJob;
use Workdo\DoubleEntry\Events\CreateJournalAccount;
use Workdo\MedicalLabManagement\Events\CreateLabPatient;
use Workdo\MedicalLabManagement\Events\CreateLabRequest;
use Workdo\Lead\Events\CreateLead;
use Workdo\Hrm\Events\CreateLeave;
use Workdo\FixEquipment\Events\CreateLicence;
use Workdo\Hrm\Events\CreateLoan;
use Workdo\CMMS\Events\CreateLocation;
use Workdo\MachineRepairManagement\Events\CreateMachine;
use Workdo\FixEquipment\Events\CreateMaintenance;
use Workdo\PropertyManagement\Events\CreateMaintenanceRequest;
use Workdo\Fleet\Events\CreateMaintenances;
use Workdo\BeverageManagement\Events\CreateManufacturing;
use Workdo\Hrm\Events\CreateMarkAttendance;
use Workdo\MarketingPlan\Events\CreateMarketingPlan;
use Workdo\McKinseyModel\Events\CreateMcKinseyModel;
use Workdo\GymManagement\Events\CreateMeasurement;
use Workdo\MedicalLabManagement\Events\CreateMedicalAppoinment;
use Workdo\HospitalManagement\Events\CreateMedicalRecords;
use Workdo\MeetingHub\Events\CreateMeeingHubMeeting;
use Workdo\MeetingHub\Events\CreateMeeingHubMeetingType;
use Workdo\Sales\Events\CreateMeeting;
use Workdo\GymManagement\Events\CreateMembershipPlan;
use Workdo\CateringManagement\Events\CreateMenuSelection;
use Workdo\Taskly\Events\CreateMilestone;
use Workdo\DairyCattleManagement\Events\CreateMilkInventory;
use Workdo\DairyCattleManagement\Events\CreateMilkProduct;
use Workdo\Hrm\Events\CreateMonthlyPayslip;
use Workdo\MovieShowBookingSystem\Events\CreateMovieCast;
use Workdo\MovieShowBookingSystem\Events\CreateMovieShow;
use Workdo\MusicInstitute\Events\CreateMusicClass;
use Workdo\MusicInstitute\Events\CreateMusicInstrument;
use Workdo\MusicInstitute\Events\CreateMusicStudent;
use Workdo\MusicInstitute\Events\CreateMusicTeacher;
use Workdo\Newspaper\Events\CreateNewspaperAds;
use Workdo\Newspaper\Events\CreateNewspaperAgent;
use Workdo\Newspaper\Events\CreateNewspaperDistributions;
use Workdo\Newspaper\Events\CreateNewspaperInvoice;
use Workdo\Newspaper\Events\CreateNewspaperJournalistInfo;
use Workdo\Newspaper\Events\CreateNewspaperJournalist;
use Workdo\Newspaper\Events\CreateNewspaper;
use Workdo\Notes\Events\CreateNotes;
use Workdo\Sales\Events\CreateOpportunities;
use Workdo\Hrm\Events\CreateOtherPayment;
use Workdo\Hrm\Events\CreateOvertime;
use Workdo\PESTAnalysisModel\Events\CreatePESTAnalysisModel;
use Workdo\PESTELAnalysisModel\Events\CreatePESTELAnalysisModel;
use Workdo\BeverageManagement\Events\CreatePackaging;
use Workdo\Holidayz\Events\CreatePageOption;
use Workdo\ChildcareManagement\Events\CreateParent;
use Workdo\ParkingManagement\Events\CreateParking;
use Workdo\ParkingManagement\Events\CreateParkingPayment;
use Workdo\CMMS\Events\CreatePart;
use Workdo\MedicalLabManagement\Events\CreatePatientCard;
use Workdo\HospitalManagement\Events\CreatePatient;
use Workdo\CarDealership\Events\CreatePaymentCarPurchase;
use Workdo\CarDealership\Events\CreatePaymentCarSale;
use Workdo\VehicleInspectionManagement\Events\CreatePaymentDefectsAndRepairs;
use Workdo\MachineRepairManagement\Events\CreatePaymentDiagnosis;
use App\Events\CreatePaymentInvoice;
use Workdo\Account\Events\CreatePayment;
use Workdo\Hrm\Events\CreatePaymentMonthlyPayslip;
use Workdo\Planning\Events\CreateChallenge as CreatePlanningChallenge;
use Workdo\CMMS\Events\CreatePms;
use Workdo\PortersFiveForcesModel\Events\CreatePortersFiveForcesMode;
use Workdo\Portfolio\Events\CreatePortfolio;
use Workdo\FixEquipment\Events\CreatePreDefinedKit;
use Workdo\ProductService\Events\CreateProduct;
use Workdo\Taskly\Events\CreateProject;
use Workdo\Hrm\Events\CreatePromotion;
use Workdo\PropertyManagement\Events\CreatePropertyInvoicePayment;
use Workdo\PropertyManagement\Events\CreateProperty;
use Workdo\PropertyManagement\Events\CreatePropertyUnit;
use App\Events\CreateProposal;
use Workdo\SupportTicket\Events\CreatePublicTicket;
use App\Events\CreatePurchase;
use Workdo\ConsignmentManagement\Events\CreatePurchaseOrder;
use Workdo\Appointment\Events\CreateQuestion;
use Workdo\Quotation\Events\CreateQuotation;
use Workdo\Sales\Events\CreateQuote;
use Workdo\Feedback\Events\CreateRating;
use Workdo\BeverageManagement\Events\CreateRawMaterial;
use Workdo\Reminder\Events\CreateReminder;
use Workdo\RentalManagement\Events\CreateRental;
use Workdo\RepairManagementSystem\Events\CreateRepairOrderRequest;
use Workdo\RepairManagementSystem\Events\CreateRepairPart;
use Workdo\MachineRepairManagement\Events\CreateRepairRequest;
use Workdo\Requests\Events\CreateRequests;
use Workdo\Hrm\Events\CreateResignation;
use Workdo\RestaurantMenu\Events\CreateRestaurantCustomer;
use Workdo\Retainer\Events\CreateRetainer;
use Workdo\RoadMapCentral\Events\CreateRoadmapIdeas;
use Workdo\RoadMapCentral\Events\CreateRoadmap;
use Workdo\Holidayz\Events\CreateRoomBooking;
use Workdo\Holidayz\Events\CreateRoomFacility;
use Workdo\Holidayz\Events\CreateRoomFeature;
use Workdo\Holidayz\Events\CreateRoom;
use Workdo\Rotas\Events\CreateRota;
use Workdo\SWOTAnalysisModel\Events\CreateSWOTAnalysismodel;
use Workdo\ConsignmentManagement\Events\CreateSaleOrder;
use Workdo\Sales\Events\CreateSalesAccount;
use Workdo\Sales\Events\CreateSalesDocument;
use Workdo\Sales\Events\CreateSalesInvoice;
use Workdo\Sales\Events\CreateSalesOrderConvert;
use Workdo\Sales\Events\CreateSalesOrder;
use Workdo\Hrm\Events\CreateSaturationDeduction;
use Workdo\School\Events\CreateSchoolHomework;
use Workdo\School\Events\CreateSchoolParent;
use Workdo\School\Events\CreateSchoolStudent;
use Workdo\MovieShowBookingSystem\Events\CreateSeatingTemplate;
use Workdo\GarageManagement\Events\CreateService;
use Workdo\SideMenuBuilder\Events\CreateSideMenuBuilder;
use Workdo\Spreadsheet\Events\CreateSpreadsheet;
use Workdo\School\Events\CreateSubject;
use Workdo\CMMS\Events\CreateSupplier;
use Workdo\Taskly\Events\CreateTask;
use Workdo\Feedback\Events\CreateTemplate;
use Workdo\PropertyManagement\Events\CreateTenant;
use Workdo\Hrm\Events\CreateTermination;
use Workdo\SupportTicket\Events\CreateTicket;
use Workdo\Timesheet\Events\CreateTimesheet;
use Workdo\School\Events\CreateTimetable;
use Workdo\ToDo\Events\CreateToDo;
use Workdo\TourTravelManagement\Events\CreateTourBooking;
use Workdo\TourTravelManagement\Events\CreateTourInquiry;
use Workdo\TourTravelManagement\Events\CreateTour;
use Workdo\Training\Events\CreateTrainer;
use Workdo\Training\Events\CreateTraining;
use Workdo\Hrm\Events\CreateTransfer;
use Workdo\Hrm\Events\CreateTrip;
use Workdo\TVStudio\Events\CreateBlog as CreateTvStudioBlog;
use Workdo\TVStudio\Events\CreateTvStudioContent;
use Workdo\TVStudio\Events\CreateTvStudioContentOrder;
use Workdo\TVStudio\Events\CreateTvStudioCoupon;
use Workdo\TVStudio\Events\CreateTvStudioCustomPage;
use Workdo\TVStudio\Events\CreateTvStudioCustomer;
use Workdo\TVStudio\Events\CreateTvStudioPlaylist;
use App\Events\CreateUser;
use Workdo\VehicleBookingManagement\Events\CreateVehicleBooking;
use Workdo\Fleet\Events\CreateVehicle;
use Workdo\VehicleBookingManagement\Events\CreateVehicleRoute;
use Workdo\Account\Events\CreateVendor;
use Workdo\VideoHub\Events\CreateVideoHubComment;
use Workdo\VideoHub\Events\CreateVideoHubVideo;
use Workdo\VisitorManagement\Events\CreateVisitReason;
use Workdo\VisitorManagement\Events\CreateVisitorLog;
use App\Events\CreateWarehouse;
use Workdo\Hrm\Events\CreateWarning;
use Workdo\DairyCattleManagement\Events\CreateWeight;
use Workdo\Workflow\Events\CreateWorkflow;
use Workdo\CMMS\Events\CreateWorkorder;
use Workdo\GymManagement\Events\CreateWorkoutPlan;
use Workdo\CMMS\Events\CreateWorkrequest;
use Workdo\ZoomMeeting\Events\CreateZoommeeting;
use Workdo\RepairManagementSystem\Events\CretaeRepairInvoice;
use Workdo\Lead\Events\DealAddCall;
use Workdo\Lead\Events\DealAddClient;
use Workdo\Lead\Events\DealAddDiscussion;
use Workdo\Lead\Events\DealAddEmail;
use Workdo\Lead\Events\DealAddNote;
use Workdo\Lead\Events\DealAddProduct;
use Workdo\Lead\Events\DealAddUser;
use Workdo\Lead\Events\DealCallUpdate;
use Workdo\Lead\Events\DealMoved;
use Workdo\Lead\Events\DealSourceUpdate;
use Workdo\Lead\Events\DealUploadFile;
use Workdo\Account\Events\DuplicateBill;
use Workdo\Bookings\Events\DuplicateBookingsPackage;
use App\Events\DuplicateInvoice;
use App\Events\DuplicateProposal;
use Workdo\RentalManagement\Events\DuplicateRental;
use Workdo\FormBuilder\Events\FormBuilderConvertTo;
use Workdo\HospitalManagement\Events\HospitalAppointmentStatus;
use Workdo\ChildcareManagement\Events\InquiryStatusChange;
use Workdo\Recruitment\Events\JobApplicationArchive;
use Workdo\Recruitment\Events\JobApplicationChangeOrder;
use Workdo\LaundryManagement\Events\LaundryRequestCreate;
use Workdo\LaundryManagement\Events\LaundryRequestUpdate;
use Workdo\Lead\Events\LeadAddCall;
use Workdo\Lead\Events\LeadAddDiscussion;
use Workdo\Lead\Events\LeadAddEmail;
use Workdo\Lead\Events\LeadAddNote;
use Workdo\Lead\Events\LeadAddProduct;
use Workdo\Lead\Events\LeadAddUser;
use Workdo\Lead\Events\LeadConvertDeal;
use Workdo\Lead\Events\LeadMoved;
use Workdo\Lead\Events\LeadSourceUpdate;
use Workdo\Lead\Events\LeadUpdateCall;
use Workdo\Lead\Events\LeadUploadFile;
use Workdo\Hrm\Events\LeaveStatus;
use Workdo\LaundryManagement\Events\LundaryRequestInvoiceCreate;
use Workdo\CourierManagement\Events\Manualpaymentdatastore;
use Workdo\CourierManagement\Events\Manualpaymentdataupdate;
use Workdo\PharmacyManagement\Events\MedicineCreate;
use Workdo\PharmacyManagement\Events\MedicineUpdate;
use Workdo\MobileServiceManagement\Events\MobileServiceCreate;
use Workdo\MobileServiceManagement\Events\MobileServicePendingRequestAccept;
use Workdo\MobileServiceManagement\Events\MobileServicePendingRequestReject;
use Workdo\MobileServiceManagement\Events\MobileServiceUpdate;
use App\Events\PaymentReminderInvoice;
use Workdo\Hrm\Events\PayslipSend;
use Workdo\PharmacyManagement\Events\PharmacyBillCreate;
use Workdo\PharmacyManagement\Events\PharmacyBillUpdate;
use Workdo\PharmacyManagement\Events\PharmacyInvoiceCreate;
use Workdo\PharmacyManagement\Events\PharmacyInvoicePaymentCreate;
use Workdo\PharmacyManagement\Events\PharmacyInvoiceUpdate;
use Workdo\Portfolio\Events\PortfolioCategoryCreate;
use Workdo\Taskly\Events\ProjectInviteUser;
use Workdo\Taskly\Events\ProjectShareToClient;
use Workdo\Taskly\Events\ProjectUploadFiles;
use Workdo\Sales\Events\QuoteDuplicate;
use Workdo\Account\Events\ResentBill;
use App\Events\ResentInvoice;
use App\Events\ResentProposal;
use App\Events\ResentPurchase;
use Workdo\Retainer\Events\ResentRetainer;
use Workdo\Retainer\Events\RetainerConvertToInvoice;
use Workdo\Retainer\Events\RetainerDuplicate;
use Workdo\SalesAgent\Events\SalesAgentCreate;
use Workdo\SalesAgent\Events\SalesAgentProgramCreate;
use Workdo\SalesAgent\Events\SalesAgentProgramUpdate;
use Workdo\SalesAgent\Events\SalesAgentUpdate;
use Workdo\Sales\Events\SalesInvoiceItemDuplicate;
use Workdo\Sales\Events\SalesOrderDuplicate;
use Workdo\Contract\Events\SendMailContract;
use Workdo\Rotas\Events\SendRotasViaEmail;
use Workdo\Account\Events\SentBill;
use App\Events\SentInvoice;
use App\Events\SentProposal;
use App\Events\SentPurchase;
use Workdo\Lead\Events\StatusChangeDealTask;
use App\Events\StatusChangeProposal;
use Workdo\Holidayz\Events\StatusChangeRoomBooking;
use Workdo\FixEquipment\Events\UpdateAccessories;
use Workdo\School\Events\UpdateAdmission;
use Workdo\LegalCaseManagement\Events\UpdateAdvocate;
use Workdo\AgricultureManagement\Events\UpdateAgricultureActivities;
use Workdo\AgricultureManagement\Events\UpdateAgricultureCanal;
use Workdo\AgricultureManagement\Events\UpdateAgricultureClaimType;
use Workdo\AgricultureManagement\Events\UpdateAgricultureCrop;
use Workdo\AgricultureManagement\Events\UpdateAgricultureCultivation;
use Workdo\AgricultureManagement\Events\UpdateAgricultureCycles;
use Workdo\AgricultureManagement\Events\UpdateAgricultureDepartment;
use Workdo\AgricultureManagement\Events\UpdateAgricultureEquipment;
use Workdo\AgricultureManagement\Events\UpdateAgricultureOffices;
use Workdo\AgricultureManagement\Events\UpdateAgricultureProcess;
use Workdo\AgricultureManagement\Events\UpdateAgricultureSeason;
use Workdo\AgricultureManagement\Events\UpdateAgricultureSeasonType;
use Workdo\AgricultureManagement\Events\UpdateAgricultureServiceProduct;
use Workdo\AgricultureManagement\Events\UpdateAgricultureServices;
use Workdo\AgricultureManagement\Events\UpdateAgricultureUser;
use Workdo\AgricultureManagement\Events\UpdateAgriculturefleet;
use Workdo\Hrm\Events\UpdateAllowance;
use Workdo\DairyCattleManagement\Events\UpdateAnimal;
use Workdo\Hrm\Events\UpdateAnnouncement;
use Workdo\Appointment\Events\UpdateAppointment;
use Workdo\Performance\Events\UpdateAppraisal;
use Workdo\Internalknowledge\Events\UpdateArticle;
use Workdo\FixEquipment\Events\UpdateAsset;
use Workdo\Assets\Events\UpdateAssets;
use Workdo\FixEquipment\Events\UpdateAudit;
use Workdo\Rotas\Events\UpdateAvailability;
use Workdo\Hrm\Events\UpdateAward;
use Workdo\Account\Events\UpdateBankAccount;
use Workdo\Account\Events\UpdateBankTransfer;
use Workdo\BeautySpaManagement\Events\UpdateBeautyBooking;
use Workdo\BeautySpaManagement\Events\UpdateBeautyService;
use Workdo\Account\Events\UpdateBill;
use Workdo\BeverageManagement\Events\UpdateBillOfMaterial;
use Workdo\LMS\Events\UpdateBlog;
use Workdo\Internalknowledge\Events\UpdateBook;
use Workdo\Holidayz\Events\UpdateBookingCoupon;
use Workdo\Fleet\Events\UpdateBooking;
use Workdo\Bookings\Events\UpdateBookingsAppointment;
use Workdo\Bookings\Events\UpdateBookingsCustomer;
use Workdo\Bookings\Events\UpdateBookingsPackage;
use Workdo\Bookings\Events\UpdateBookingsStaff;
use Workdo\DairyCattleManagement\Events\UpdateBreeding;
use Workdo\Taskly\Events\UpdateBug;
use Workdo\Taskly\Events\UpdateBugStage;
use Workdo\Hrm\Events\UpdateBulkAttendance;
use Workdo\VCard\Events\UpdateBusiness;
use Workdo\BusinessModel\Events\UpdateBusinessModel;
use Workdo\BusinessPlan\Events\UpdateBusinessPlan;
use Workdo\BusinessProcessMapping\Events\UpdateBusinessProcessMapping;
use Workdo\Sales\Events\UpdateCall;
use Workdo\CallHub\Events\UpdateCallList;
use Workdo\CallHub\Events\UpdateCallhubAdavance;
use Workdo\CarDealership\Events\UpdateCarPurchase;
use Workdo\CarDealership\Events\UpdateCarSale;
use Workdo\LegalCaseManagement\Events\UpdateCaseInitiator;
use Workdo\LegalCaseManagement\Events\UpdateCase;
use Workdo\CateringManagement\Events\UpdateCateringCustomer;
use Workdo\InnovationCenter\Events\UpdateChallenge;
use Workdo\Planning\Events\UpdateCharter;
use Workdo\ChildcareManagement\Events\UpdateChildAttendance;
use Workdo\ChildcareManagement\Events\UpdateChildBulkAttendance;
use Workdo\ChildcareManagement\Events\UpdateChild;
use Workdo\School\Events\UpdateClassroom;
use Workdo\CleaningManagement\Events\UpdateCleaningBooking;
use Workdo\CleaningManagement\Events\UpdateCleaningTeam;
use Workdo\BeverageManagement\Events\UpdateCollectionCenter;
use Workdo\Hrm\Events\UpdateCommission;
use Workdo\Commission\Events\UpdateCommissionPlan;
use Workdo\Sales\Events\UpdateCommonCase;
use Workdo\Hrm\Events\UpdateCompanyPolicy;
use Workdo\Hrm\Events\UpdateComplaint;
use Workdo\ConsignmentManagement\Events\UpdateConsignment;
use Workdo\ConsignmentManagement\Events\UpdateProduct as UpdateConsignmentProduct;
use Workdo\FixEquipment\Events\UpdateConsumables;
use Workdo\Sales\Events\UpdateContact;
use Workdo\LMS\Events\UpdateCourseCoupon;
use Workdo\LMS\Events\UpdateCourse;
use Workdo\LegalCaseManagement\Events\UpdateCourt;
use Workdo\InnovationCenter\Events\UpdateCreativity;
use Workdo\CustomField\Events\UpdateCustomField;
use Workdo\LMS\Events\UpdateCustomPage;
use Workdo\Recruitment\Events\UpdateCustomQuestion;
use Workdo\Account\Events\UpdateCustomer;
use Workdo\DairyCattleManagement\Events\UpdateDailyMilkSheet;
use Workdo\Lead\Events\UpdateDeal;
use Workdo\Lead\Events\UpdateDealTask;
use Workdo\CarDealership\Events\UpdateDealershipProduct;
use Workdo\VehicleInspectionManagement\Events\UpdateDefectsAndRepairs;
use Workdo\MachineRepairManagement\Events\UpdateDiagnosis;
use Workdo\RestaurantMenu\Events\UpdateDiningTable;
use Workdo\LegalCaseManagement\Events\UpdateDivision;
use Workdo\HospitalManagement\Events\UpdateDoctor;
use Workdo\Hrm\Events\UpdateDocument;
use Workdo\PropertyManagement\Events\UpdateDocumentType;
use Workdo\Fleet\Events\UpdateDriver;
use Workdo\DrivingSchool\Events\UpdateDrivingClass;
use Workdo\DrivingSchool\Events\UpdateDrivingInvoice;
use Workdo\DrivingSchool\Events\UpdateDrivingStudent;
use Workdo\DrivingSchool\Events\UpdateDrivingVehicle;
use Workdo\Hrm\Events\UpdateEmployee;
use Workdo\Hrm\Events\UpdateEmployeeSalary;
use Workdo\CateringManagement\Events\UpdateEventDetail;
use Workdo\Hrm\Events\UpdateEvent;
use Workdo\LegalCaseManagement\Events\UpdateExpense;
use Workdo\ChildcareManagement\Events\UpdateFee;
use Workdo\LegalCaseManagement\Events\UpdateFeeReciept;
use Workdo\LegalCaseManagement\Events\UpdateFeeRecieve;
use Workdo\FileSharing\Events\UpdateFile;
use Workdo\Goal\Events\UpdateFinacialGoal;
use Workdo\FixEquipment\Events\UpdateComponent as UpdateFixComponent;
use Workdo\Fleet\Events\UpdateFleetCustomer;
use Workdo\FormBuilder\Events\UpdateFormField;
use Workdo\FormBuilder\Events\UpdateForm;
use Workdo\FreightManagementSystem\Events\UpdateFreightBookingRequest;
use Workdo\FreightManagementSystem\Events\UpdateFreightCustomer;
use Workdo\Fleet\Events\UpdateFuel;
use Workdo\GarageManagement\Events\UpdateGarageVehicle;
use Workdo\Performance\Events\UpdateGoalTracking;
use Workdo\GymManagement\Events\UpdateGymMember;
use Workdo\GymManagement\Events\UpdateGymTrainer;
use Workdo\DairyCattleManagement\Events\UpdateHealth;
use Workdo\LegalCaseManagement\Events\UpdateHighCourt;
use Workdo\Hrm\Events\UpdateHolidays;
use Workdo\HospitalManagement\Events\UpdateHospitalAppointment;
use Workdo\HospitalManagement\Events\UpdateHospitalBed;
use Workdo\HospitalManagement\Events\UpdateHospitalMedicine;
use Workdo\Holidayz\Events\UpdateHotelCustomer;
use Workdo\Holidayz\Events\UpdateHotelService;
use Workdo\Performance\Events\UpdateIndicator;
use Workdo\ChildcareManagement\Events\UpdateInquiry;
use Workdo\VehicleInspectionManagement\Events\UpdateInspectionList;
use Workdo\VehicleInspectionManagement\Events\UpdateInspectionRequest;
use Workdo\VehicleInspectionManagement\Events\UpdateInspectionVehicle;
use Workdo\Fleet\Events\UpdateInsurance;
use Workdo\Recruitment\Events\UpdateInterviewSchedule;
use App\Events\UpdateInvoice;
use Workdo\Recruitment\Events\UpdateJobBoard;
use Workdo\Recruitment\Events\UpdateJobCandidate;
use Workdo\Recruitment\Events\UpdateJob;
use Workdo\DoubleEntry\Events\UpdateJournalAccount;
use Workdo\MedicalLabManagement\Events\UpdateLabPatient;
use Workdo\MedicalLabManagement\Events\UpdateLabRequest;
use Workdo\Lead\Events\UpdateLead;
use Workdo\Hrm\Events\UpdateLeave;
use Workdo\FixEquipment\Events\UpdateLicence;
use Workdo\Hrm\Events\UpdateLoan;
use Workdo\CMMS\Events\UpdateLocation;
use Workdo\MachineRepairManagement\Events\UpdateMachine;
use Workdo\FixEquipment\Events\UpdateMaintenance;
use Workdo\PropertyManagement\Events\UpdateMaintenanceRequest;
use Workdo\Fleet\Events\UpdateMaintenances;
use Workdo\BeverageManagement\Events\UpdateManufacturing;
use Workdo\Hrm\Events\UpdateMarkAttendance;
use Workdo\MarketingPlan\Events\UpdateMarketingPlan;
use Workdo\McKinseyModel\Events\UpdateMcKinseyModel;
use Workdo\GymManagement\Events\UpdateMeasurement;
use Workdo\MedicalLabManagement\Events\UpdateMedicalAppoinment;
use Workdo\HospitalManagement\Events\UpdateMedicalRecords;
use Workdo\MeetingHub\Events\UpdateMeeingHubMeeting;
use Workdo\MeetingHub\Events\UpdateMeeingHubMeetingType;
use Workdo\Sales\Events\UpdateMeeting;
use Workdo\GymManagement\Events\UpdateMembershipPlan;
use Workdo\CateringManagement\Events\UpdateMenuSelection;
use Workdo\Taskly\Events\UpdateMilestone;
use Workdo\DairyCattleManagement\Events\UpdateMilkInventory;
use Workdo\DairyCattleManagement\Events\UpdateMilkProduct;
use Workdo\Hrm\Events\UpdateMonthlyPayslip;
use Workdo\MovieShowBookingSystem\Events\UpdateMovieCast;
use Workdo\MovieShowBookingSystem\Events\UpdateMovieShow;
use Workdo\MusicInstitute\Events\UpdateMusicClass;
use Workdo\MusicInstitute\Events\UpdateMusicInstrument;
use Workdo\MusicInstitute\Events\UpdateMusicStudent;
use Workdo\MusicInstitute\Events\UpdateMusicTeacher;
use Workdo\Newspaper\Events\UpdateNewspaperAds;
use Workdo\Newspaper\Events\UpdateNewspaperAgent;
use Workdo\Newspaper\Events\UpdateNewspaperDistributions;
use Workdo\Newspaper\Events\UpdateNewspaperInvoice;
use Workdo\Newspaper\Events\UpdateNewspaperJournalistInfo;
use Workdo\Newspaper\Events\UpdateNewspaperJournalist;
use Workdo\Newspaper\Events\UpdateNewspaper;
use Workdo\Notes\Events\UpdateNotes;
use Workdo\Sales\Events\UpdateOpportunities;
use Workdo\Hrm\Events\UpdateOtherPayment;
use Workdo\Hrm\Events\UpdateOvertime;
use Workdo\PESTAnalysisModel\Events\UpdatePESTAnalysisModel;
use Workdo\PESTELAnalysisModel\Events\UpdatePESTELAnalysisModel;
use Workdo\BeverageManagement\Events\UpdatePackaging;
use Workdo\Holidayz\Events\UpdatePageOption;
use Workdo\ChildcareManagement\Events\UpdateParent;
use Workdo\MedicalLabManagement\Events\UpdatePatientCard;
use Workdo\HospitalManagement\Events\UpdatePatient;
use Workdo\Account\Events\UpdatePayment;
use Workdo\Planning\Events\UpdateChallenge as UpdatePlanningChallenge;
use Workdo\PortersFiveForcesModel\Events\UpdatePortersFiveForcesMode;
use Workdo\Portfolio\Events\UpdatePortfolioCategory;
use Workdo\Portfolio\Events\UpdatePortfolio;
use Workdo\FixEquipment\Events\UpdatePreDefinedKit;
use Workdo\ProductService\Events\UpdateProduct;
use Workdo\Hrm\Events\UpdatePromotion;
use Workdo\PropertyManagement\Events\UpdateProperty;
use Workdo\PropertyManagement\Events\UpdatePropertyUnit;
use App\Events\UpdateProposal;
use App\Events\UpdatePurchase;
use Workdo\ConsignmentManagement\Events\UpdatePurchaseOrder;
use Workdo\Appointment\Events\UpdateQuestion;
use Workdo\Quotation\Events\UpdateQuotation;
use Workdo\Sales\Events\UpdateQuote;
use Workdo\BeverageManagement\Events\UpdateRawMaterial;
use Workdo\Reminder\Events\UpdateReminder;
use Workdo\RentalManagement\Events\UpdateRental;
use Workdo\RepairManagementSystem\Events\UpdateRepairOrderRequest;
use Workdo\RepairManagementSystem\Events\UpdateRepairPart;
use Workdo\MachineRepairManagement\Events\UpdateRepairRequest;
use Workdo\Requests\Events\UpdateRequests;
use Workdo\Hrm\Events\UpdateResignation;
use Workdo\RestaurantMenu\Events\UpdateRestaurantCustomer;
use Workdo\Retainer\Events\UpdateRetainer;
use Workdo\Account\Events\UpdateRevenue;
use Workdo\RoadMapCentral\Events\UpdateRoadmapIdeas;
use Workdo\RoadMapCentral\Events\UpdateRoadmap;
use Workdo\Holidayz\Events\UpdateRoomBooking;
use Workdo\Holidayz\Events\UpdateRoomFacility;
use Workdo\Holidayz\Events\UpdateRoomFeature;
use Workdo\Holidayz\Events\UpdateRoom;
use Workdo\Rotas\Events\UpdateRota;
use Workdo\SWOTAnalysisModel\Events\UpdateSWOTAnalysismodel;
use Workdo\ConsignmentManagement\Events\UpdateSaleOrder;
use Workdo\Sales\Events\UpdateSalesAccount;
use Workdo\Sales\Events\UpdateSalesDocument;
use Workdo\Sales\Events\UpdateSalesInvoice;
use Workdo\Sales\Events\UpdateSalesOrder;
use Workdo\Hrm\Events\UpdateSaturationDeduction;
use Workdo\School\Events\UpdateSchoolHomework;
use Workdo\School\Events\UpdateSchoolParent;
use Workdo\School\Events\UpdateSchoolStudent;
use Workdo\MovieShowBookingSystem\Events\UpdateSeatingTemplate;
use Workdo\GarageManagement\Events\UpdateService;
use Workdo\SideMenuBuilder\Events\UpdateSideMenuBuilder;
use Workdo\Spreadsheet\Events\UpdateSpreadsheet;
use Workdo\School\Events\UpdateSubject;
use Workdo\Taskly\Events\UpdateTask;
use Workdo\Taskly\Events\UpdateTaskStage;
use Workdo\Feedback\Events\UpdateTemplate;
use Workdo\PropertyManagement\Events\UpdateTenant;
use Workdo\Hrm\Events\UpdateTermination;
use Workdo\SupportTicket\Events\UpdateTicket;
use Workdo\Timesheet\Events\UpdateTimesheet;
use Workdo\School\Events\UpdateTimetable;
use Workdo\ToDo\Events\UpdateToDo;
use Workdo\TourTravelManagement\Events\UpdateTourInquiry;
use Workdo\TourTravelManagement\Events\UpdateTour;
use Workdo\Training\Events\UpdateTrainer;
use Workdo\Training\Events\UpdateTraining;
use Workdo\Hrm\Events\UpdateTransfer;
use Workdo\Hrm\Events\UpdateTrip;
use Workdo\TVStudio\Events\UpdateBlog as UpdateTvStudioBlog;
use Workdo\TVStudio\Events\UpdateTvStudioContent;
use Workdo\TVStudio\Events\UpdateTvStudioCoupon;
use Workdo\TVStudio\Events\UpdateTvStudioCustomPage;
use Workdo\TVStudio\Events\UpdateTvStudioCustomer;
use Workdo\TVStudio\Events\UpdateTvStudioPlaylist;
use App\Events\UpdateUser;
use Workdo\Fleet\Events\UpdateVehicle;
use Workdo\VehicleBookingManagement\Events\UpdateVehicleRoute;
use Workdo\Account\Events\UpdateVendor;
use Workdo\VideoHub\Events\UpdateVideoHubVideo;
use Workdo\VisitorManagement\Events\UpdateVisitReason;
use Workdo\VisitorManagement\Events\UpdateVisitorLog;
use App\Events\UpdateWarehouse;
use Workdo\Hrm\Events\UpdateWarning;
use Workdo\DairyCattleManagement\Events\UpdateWeight;
use Workdo\Rotas\Events\UpdateWorkSchedule;
use Workdo\Workflow\Events\UpdateWorkflow;
use Workdo\BeautySpaManagement\Events\UpdateWorkingHours;
use Workdo\GymManagement\Events\UpdateWorkoutPlan;
use Workdo\contract\Events\Updatecontract;
use Workdo\VCard\Events\CreateAppointment as VcardCreateAppointment;
use Workdo\VCard\Events\CreateContact as VcardCreateContact;
use Workdo\VCard\Events\UpdateAppointment as VcardUpdateAppointment;
use Workdo\VCard\Events\UpdateContact as VcardUpdateContact;
use Workdo\FormBuilder\Events\ViewForm;
use Workdo\WasteManagement\Events\WasteCollectionRequestCreate;
use Workdo\WasteManagement\Events\WasteCollectionRequestUpdate;
use Workdo\WasteManagement\Events\WastecollectionConvertedToTrip;
use Workdo\Account\Events\CreatePaymentBill;
use Workdo\Account\Events\CreateRevenue;
use Workdo\AIDocument\Events\UpdateHistory;
use Workdo\AIImage\Events\ImageGenerat;
use Workdo\CMMS\Events\UpdateCmmspos;
use Workdo\CMMS\Events\UpdateComponent;
use Workdo\CMMS\Events\UpdatePart;
use Workdo\CMMS\Events\UpdatePms;
use Workdo\CMMS\Events\UpdateSupplier;
use Workdo\CMMS\Events\UpdateWorkorder;
use Workdo\FormBuilder\Events\ConvertIntoLeadSetting;
use Workdo\Retainer\Events\CreatePaymentRetainer;
use Workdo\Training\Events\UpdateStatus;
use App\Events\CreatePaymentPurchase;

// For invoice payment
use Workdo\Skrill\Events\SkrillPaymentStatus;
use Workdo\SSPay\Events\SSpayPaymentStatus;
use Workdo\Stripe\Events\StripePaymentStatus;
use Workdo\Payfast\Events\PayfastPaymentStatus;
use Workdo\Paypal\Events\PaypalPaymentStatus;
use Workdo\Paystack\Events\PaystackPaymentStatus;
use Workdo\PayTab\Events\PaytabPaymentStatus;
use Workdo\Paytm\Events\PaytmPaymentStatus;
use Workdo\PayTR\Events\PaytrPaymentStatus;
use Workdo\Mercado\Events\MercadoPaymentStatus;
use Workdo\Mollie\Events\MolliePaymentStatus;
use Workdo\Benefit\Events\BenefitPaymentStatus;
use Workdo\Cashfree\Events\CashfreePaymentStatus;
use Workdo\Toyyibpay\Events\ToyyibpayPaymentStatus;
use Workdo\Razorpay\Events\RazorpayPaymentStatus;
use Workdo\Flutterwave\Events\FlutterwavePaymentStatus;
use Workdo\Iyzipay\Events\IyzipayPaymentStatus;
use Workdo\Coingate\Events\CoingatePaymentStatus;
use Workdo\AamarPay\Events\AamarPaymentStatus;
use Workdo\YooKassa\Events\YooKassaPaymentStatus;
use App\Events\BankTransferPaymentStatus;

use Workdo\ActivityLog\Listeners\AddDayoffLis;
use Workdo\ActivityLog\Listeners\AdmissionConvertLis;
use Workdo\ActivityLog\Listeners\AppointmentStatusLis;
use Workdo\ActivityLog\Listeners\BusinessStatusLis;
use Workdo\ActivityLog\Listeners\ChangeStatusCleaningBookingRequestLis;
use Workdo\ActivityLog\Listeners\ChangeStatusNewspaperInvoiceLis;
use Workdo\ActivityLog\Listeners\CompanyMenuListener;
use Workdo\ActivityLog\Listeners\ConvertToEmployeeLis;
use Workdo\ActivityLog\Listeners\ConvertToInvoiceLis;
use Workdo\ActivityLog\Listeners\CopyContractLis;
use Workdo\ActivityLog\Listeners\CouriercreateLis;
use Workdo\ActivityLog\Listeners\CourierupdateLis;
use Workdo\ActivityLog\Listeners\CreateAccessoriesLis;
use Workdo\ActivityLog\Listeners\CreateAdmissionLis;
use Workdo\ActivityLog\Listeners\CreateAdvocateLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureActivitiesLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureCanalLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureClaimTypeLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureCropLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureCultivationLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureCyclesLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureDepartmentLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureEquipmentLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureOfficesLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureProcessLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureSeasonLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureSeasonTypeLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureServiceProductLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureServicesLis;
use Workdo\ActivityLog\Listeners\CreateAgricultureUserLis;
use Workdo\ActivityLog\Listeners\CreateAgriculturefleetLis;
use Workdo\ActivityLog\Listeners\CreateAllowanceLis;
use Workdo\ActivityLog\Listeners\CreateAnimalLis;
use Workdo\ActivityLog\Listeners\CreateAnnouncementLis;
use Workdo\ActivityLog\Listeners\CreateAppointmentLis;
use Workdo\ActivityLog\Listeners\CreateAppointmentsLis;
use Workdo\ActivityLog\Listeners\CreateAppraisalLis;
use Workdo\ActivityLog\Listeners\CreateArticleLis;
use Workdo\ActivityLog\Listeners\CreateAssetLis;
use Workdo\ActivityLog\Listeners\CreateAssetsLis;
use Workdo\ActivityLog\Listeners\CreateAuditLis;
use Workdo\ActivityLog\Listeners\CreateAvailabilityLis;
use Workdo\ActivityLog\Listeners\CreateAwardLis;
use Workdo\ActivityLog\Listeners\CreateBankAccountLis;
use Workdo\ActivityLog\Listeners\CreateBankTransferLis;
use Workdo\ActivityLog\Listeners\CreateBeautyBookingLis;
use Workdo\ActivityLog\Listeners\CreateBeautyServiceLis;
use Workdo\ActivityLog\Listeners\CreateBillLis;
use Workdo\ActivityLog\Listeners\CreateBillOfMaterialLis;
use Workdo\ActivityLog\Listeners\CreateBlogLis;
use Workdo\ActivityLog\Listeners\CreateBookLis;
use Workdo\ActivityLog\Listeners\CreateBookingCouponLis;
use Workdo\ActivityLog\Listeners\CreateBookingLis;
use Workdo\ActivityLog\Listeners\CreateBookingsAppointmentLis;
use Workdo\ActivityLog\Listeners\CreateBookingsCustomerLis;
use Workdo\ActivityLog\Listeners\CreateBookingsPackageLis;
use Workdo\ActivityLog\Listeners\CreateBookingsStaffLis;
use Workdo\ActivityLog\Listeners\CreateBreedingLis;
use Workdo\ActivityLog\Listeners\CreateBugLis;
use Workdo\ActivityLog\Listeners\CreateBusinessLis;
use Workdo\ActivityLog\Listeners\CreateBusinessModelLis;
use Workdo\ActivityLog\Listeners\CreateBusinessPlanLis;
use Workdo\ActivityLog\Listeners\CreateBusinessProcessMappingLis;
use Workdo\ActivityLog\Listeners\CreateCallLis;
use Workdo\ActivityLog\Listeners\CreateCallListLis;
use Workdo\ActivityLog\Listeners\CreateCallhubAdavanceLis;
use Workdo\ActivityLog\Listeners\CreateCarPurchaseLis;
use Workdo\ActivityLog\Listeners\CreateCarSaleLis;
use Workdo\ActivityLog\Listeners\CreateCaseInitiatorLis;
use Workdo\ActivityLog\Listeners\CreateCaseLis;
use Workdo\ActivityLog\Listeners\CreateCateringCustomerLis;
use Workdo\ActivityLog\Listeners\CreateCateringInvoiceLis;
use Workdo\ActivityLog\Listeners\CreateChallengeLis;
use Workdo\ActivityLog\Listeners\CreateChangeOrderLis;
use Workdo\ActivityLog\Listeners\CreateCharterLis;
use Workdo\ActivityLog\Listeners\CreateChildAttendanceLis;
use Workdo\ActivityLog\Listeners\CreateChildLis;
use Workdo\ActivityLog\Listeners\CreateClassroomLis;
use Workdo\ActivityLog\Listeners\CreateCleaningBookingLis;
use Workdo\ActivityLog\Listeners\CreateCleaningTeamLis;
use Workdo\ActivityLog\Listeners\CreateCmmsposLis;
use Workdo\ActivityLog\Listeners\CreateCollectionCenterLis;
use Workdo\ActivityLog\Listeners\CreateCommissionLis;
use Workdo\ActivityLog\Listeners\CreateCommissionPlanLis;
use Workdo\ActivityLog\Listeners\CreateCommissionReceiptLis;
use Workdo\ActivityLog\Listeners\CreateCommonCaseLis;
use Workdo\ActivityLog\Listeners\CreateCompanyPolicyLis;
use Workdo\ActivityLog\Listeners\CreateComplaintLis;
use Workdo\ActivityLog\Listeners\CreateComponentLis;
use Workdo\ActivityLog\Listeners\CreateConsignmentLis;
use Workdo\ActivityLog\Listeners\CreateConsignmentProductLis;
use Workdo\ActivityLog\Listeners\CreateConsumablesLis;
use Workdo\ActivityLog\Listeners\CreateContactLis;
use Workdo\ActivityLog\Listeners\CreateContractLis;
use Workdo\ActivityLog\Listeners\CreateCourseCouponLis;
use Workdo\ActivityLog\Listeners\CreateCourseLis;
use Workdo\ActivityLog\Listeners\CreateCourtLis;
use Workdo\ActivityLog\Listeners\CreateCreativityLis;
use Workdo\ActivityLog\Listeners\CreateCustomFieldLis;
use Workdo\ActivityLog\Listeners\CreateCustomPageLis;
use Workdo\ActivityLog\Listeners\CreateCustomQuestionLis;
use Workdo\ActivityLog\Listeners\CreateCustomerLis;
use Workdo\ActivityLog\Listeners\CreateDailyMilkSheetLis;
use Workdo\ActivityLog\Listeners\CreateDealLis;
use Workdo\ActivityLog\Listeners\CreateDealTaskLis;
use Workdo\ActivityLog\Listeners\CreateDealershipProductLis;
use Workdo\ActivityLog\Listeners\CreateDefectsAndRepairsLis;
use Workdo\ActivityLog\Listeners\CreateDiagnosisLis;
use Workdo\ActivityLog\Listeners\CreateDiningTableLis;
use Workdo\ActivityLog\Listeners\CreateDivisionLis;
use Workdo\ActivityLog\Listeners\CreateDoctorLis;
use Workdo\ActivityLog\Listeners\CreateDocumentLis;
use Workdo\ActivityLog\Listeners\CreateDocumentTypeLis;
use Workdo\ActivityLog\Listeners\CreateDriverLis;
use Workdo\ActivityLog\Listeners\CreateDrivingClassLis;
use Workdo\ActivityLog\Listeners\CreateDrivingInvoiceLis;
use Workdo\ActivityLog\Listeners\CreateDrivingStudentLis;
use Workdo\ActivityLog\Listeners\CreateDrivingVehicleLis;
use Workdo\ActivityLog\Listeners\CreateEmployeeLis;
use Workdo\ActivityLog\Listeners\CreateEventDetailLis;
use Workdo\ActivityLog\Listeners\CreateEventLis;
use Workdo\ActivityLog\Listeners\CreateExpenseLis;
use Workdo\ActivityLog\Listeners\CreateFeeLis;
use Workdo\ActivityLog\Listeners\CreateFeeRecieptLis;
use Workdo\ActivityLog\Listeners\CreateFeeRecieveLis;
use Workdo\ActivityLog\Listeners\CreateFileLis;
use Workdo\ActivityLog\Listeners\CreateFinacialGoalLis;
use Workdo\ActivityLog\Listeners\CreateFixComponentLis;
use Workdo\ActivityLog\Listeners\CreateFleetCustomerLis;
use Workdo\ActivityLog\Listeners\CreateFormFieldLis;
use Workdo\ActivityLog\Listeners\CreateFormLis;
use Workdo\ActivityLog\Listeners\CreateFreightBookingRequestLis;
use Workdo\ActivityLog\Listeners\CreateFreightCustomerLis;
use Workdo\ActivityLog\Listeners\CreateFuelLis;
use Workdo\ActivityLog\Listeners\CreateGarageVehicleLis;
use Workdo\ActivityLog\Listeners\CreateGoalTrackingLis;
use Workdo\ActivityLog\Listeners\CreateGymMemberLis;
use Workdo\ActivityLog\Listeners\CreateGymTrainerLis;
use Workdo\ActivityLog\Listeners\CreateHealthLis;
use Workdo\ActivityLog\Listeners\CreateHighCourtLis;
use Workdo\ActivityLog\Listeners\CreateHolidaysLis;
use Workdo\ActivityLog\Listeners\CreateHospitalAppointmentLis;
use Workdo\ActivityLog\Listeners\CreateHospitalBedLis;
use Workdo\ActivityLog\Listeners\CreateHospitalMedicineLis;
use Workdo\ActivityLog\Listeners\CreateHotelCustomerLis;
use Workdo\ActivityLog\Listeners\CreateHotelServiceLis;
use Workdo\ActivityLog\Listeners\CreateIndicatorLis;
use Workdo\ActivityLog\Listeners\CreateInquiryLis;
use Workdo\ActivityLog\Listeners\CreateInspectionListLis;
use Workdo\ActivityLog\Listeners\CreateInspectionRequestLis;
use Workdo\ActivityLog\Listeners\CreateInspectionVehicleLis;
use Workdo\ActivityLog\Listeners\CreateInsuranceLis;
use Workdo\ActivityLog\Listeners\CreateInterviewScheduleLis;
use Workdo\ActivityLog\Listeners\CreateInvoiceLis;
use Workdo\ActivityLog\Listeners\CreateJobApplicationStageChangeLis;
use Workdo\ActivityLog\Listeners\CreateJobApplicationLis;
use Workdo\ActivityLog\Listeners\CreateJobBoardLis;
use Workdo\ActivityLog\Listeners\CreateJobCandidateLis;
use Workdo\ActivityLog\Listeners\CreateJobLis;
use Workdo\ActivityLog\Listeners\CreateJournalAccountLis;
use Workdo\ActivityLog\Listeners\CreateLabPatientLis;
use Workdo\ActivityLog\Listeners\CreateLabRequestLis;
use Workdo\ActivityLog\Listeners\CreateLeadLis;
use Workdo\ActivityLog\Listeners\CreateLeaveLis;
use Workdo\ActivityLog\Listeners\CreateLicenceLis;
use Workdo\ActivityLog\Listeners\CreateLoanLis;
use Workdo\ActivityLog\Listeners\CreateLocationLis;
use Workdo\ActivityLog\Listeners\CreateMachineLis;
use Workdo\ActivityLog\Listeners\CreateMaintenanceLis;
use Workdo\ActivityLog\Listeners\CreateMaintenanceRequestLis;
use Workdo\ActivityLog\Listeners\CreateMaintenancesLis;
use Workdo\ActivityLog\Listeners\CreateManufacturingLis;
use Workdo\ActivityLog\Listeners\CreateMarkAttendanceLis;
use Workdo\ActivityLog\Listeners\CreateMarketingPlanLis;
use Workdo\ActivityLog\Listeners\CreateMcKinseyModelLis;
use Workdo\ActivityLog\Listeners\CreateMeasurementLis;
use Workdo\ActivityLog\Listeners\CreateMedicalAppoinmentLis;
use Workdo\ActivityLog\Listeners\CreateMedicalRecordsLis;
use Workdo\ActivityLog\Listeners\CreateMeeingHubMeetingLis;
use Workdo\ActivityLog\Listeners\CreateMeeingHubMeetingTypeLis;
use Workdo\ActivityLog\Listeners\CreateMeetingLis;
use Workdo\ActivityLog\Listeners\CreateMembershipPlanLis;
use Workdo\ActivityLog\Listeners\CreateMenuSelectionLis;
use Workdo\ActivityLog\Listeners\CreateMilestoneLis;
use Workdo\ActivityLog\Listeners\CreateMilkInventoryLis;
use Workdo\ActivityLog\Listeners\CreateMilkProductLis;
use Workdo\ActivityLog\Listeners\CreateMonthlyPayslipLis;
use Workdo\ActivityLog\Listeners\CreateMovieCastLis;
use Workdo\ActivityLog\Listeners\CreateMovieShowLis;
use Workdo\ActivityLog\Listeners\CreateMusicClassLis;
use Workdo\ActivityLog\Listeners\CreateMusicInstrumentLis;
use Workdo\ActivityLog\Listeners\CreateMusicStudentLis;
use Workdo\ActivityLog\Listeners\CreateMusicTeacherLis;
use Workdo\ActivityLog\Listeners\CreateNewspaperAdsLis;
use Workdo\ActivityLog\Listeners\CreateNewspaperAgentLis;
use Workdo\ActivityLog\Listeners\CreateNewspaperDistributionsLis;
use Workdo\ActivityLog\Listeners\CreateNewspaperInvoiceLis;
use Workdo\ActivityLog\Listeners\CreateNewspaperJournalistInfoLis;
use Workdo\ActivityLog\Listeners\CreateNewspaperJournalistLis;
use Workdo\ActivityLog\Listeners\CreateNewspaperLis;
use Workdo\ActivityLog\Listeners\CreateNotesLis;
use Workdo\ActivityLog\Listeners\CreateOpportunitiesLis;
use Workdo\ActivityLog\Listeners\CreateOtherPaymentLis;
use Workdo\ActivityLog\Listeners\CreateOvertimeLis;
use Workdo\ActivityLog\Listeners\CreatePESTAnalysisModelLis;
use Workdo\ActivityLog\Listeners\CreatePESTELAnalysisModelLis;
use Workdo\ActivityLog\Listeners\CreatePackagingLis;
use Workdo\ActivityLog\Listeners\CreatePageOptionLis;
use Workdo\ActivityLog\Listeners\CreateParentLis;
use Workdo\ActivityLog\Listeners\CreateParkingLis;
use Workdo\ActivityLog\Listeners\CreateParkingPaymentLis;
use Workdo\ActivityLog\Listeners\CreatePartLis;
use Workdo\ActivityLog\Listeners\CreatePatientCardLis;
use Workdo\ActivityLog\Listeners\CreatePatientLis;
use Workdo\ActivityLog\Listeners\CreatePaymentCarPurchaseLis;
use Workdo\ActivityLog\Listeners\CreatePaymentCarSaleLis;
use Workdo\ActivityLog\Listeners\CreatePaymentDefectsAndRepairsLis;
use Workdo\ActivityLog\Listeners\CreatePaymentDiagnosisLis;
use Workdo\ActivityLog\Listeners\CreatePaymentInvoiceLis;
use Workdo\ActivityLog\Listeners\CreatePaymentLis;
use Workdo\ActivityLog\Listeners\CreatePaymentMonthlyPayslipLis;
use Workdo\ActivityLog\Listeners\CreatePlanningChallengeLis;
use Workdo\ActivityLog\Listeners\CreatePmsLis;
use Workdo\ActivityLog\Listeners\CreatePortersFiveForcesModeLis;
use Workdo\ActivityLog\Listeners\CreatePortfolioLis;
use Workdo\ActivityLog\Listeners\CreatePreDefinedKitLis;
use Workdo\ActivityLog\Listeners\CreateProductLis;
use Workdo\ActivityLog\Listeners\CreateProjectLis;
use Workdo\ActivityLog\Listeners\CreatePromotionLis;
use Workdo\ActivityLog\Listeners\CreatePropertyInvoicePaymentLis;
use Workdo\ActivityLog\Listeners\CreatePropertyLis;
use Workdo\ActivityLog\Listeners\CreatePropertyUnitLis;
use Workdo\ActivityLog\Listeners\CreateProposalLis;
use Workdo\ActivityLog\Listeners\CreatePublicTicketLis;
use Workdo\ActivityLog\Listeners\CreatePurchaseLis;
use Workdo\ActivityLog\Listeners\CreatePurchaseOrderLis;
use Workdo\ActivityLog\Listeners\CreateQuestionLis;
use Workdo\ActivityLog\Listeners\CreateQuotationLis;
use Workdo\ActivityLog\Listeners\CreateQuoteLis;
use Workdo\ActivityLog\Listeners\CreateRatingLis;
use Workdo\ActivityLog\Listeners\CreateRawMaterialLis;
use Workdo\ActivityLog\Listeners\CreateReminderLis;
use Workdo\ActivityLog\Listeners\CreateRentalLis;
use Workdo\ActivityLog\Listeners\CreateRepairOrderRequestLis;
use Workdo\ActivityLog\Listeners\CreateRepairPartLis;
use Workdo\ActivityLog\Listeners\CreateRepairRequestLis;
use Workdo\ActivityLog\Listeners\CreateRequestsLis;
use Workdo\ActivityLog\Listeners\CreateResignationLis;
use Workdo\ActivityLog\Listeners\CreateRestaurantCustomerLis;
use Workdo\ActivityLog\Listeners\CreateRetainerLis;
use Workdo\ActivityLog\Listeners\CreateRoadmapIdeasLis;
use Workdo\ActivityLog\Listeners\CreateRoadmapLis;
use Workdo\ActivityLog\Listeners\CreateRoomBookingLis;
use Workdo\ActivityLog\Listeners\CreateRoomFacilityLis;
use Workdo\ActivityLog\Listeners\CreateRoomFeatureLis;
use Workdo\ActivityLog\Listeners\CreateRoomLis;
use Workdo\ActivityLog\Listeners\CreateRotaLis;
use Workdo\ActivityLog\Listeners\CreateSWOTAnalysismodelLis;
use Workdo\ActivityLog\Listeners\CreateSaleOrderLis;
use Workdo\ActivityLog\Listeners\CreateSalesAccountLis;
use Workdo\ActivityLog\Listeners\CreateSalesDocumentLis;
use Workdo\ActivityLog\Listeners\CreateSalesInvoiceLis;
use Workdo\ActivityLog\Listeners\CreateSalesOrderConvertLis;
use Workdo\ActivityLog\Listeners\CreateSalesOrderLis;
use Workdo\ActivityLog\Listeners\CreateSaturationDeductionLis;
use Workdo\ActivityLog\Listeners\CreateSchoolHomeworkLis;
use Workdo\ActivityLog\Listeners\CreateSchoolParentLis;
use Workdo\ActivityLog\Listeners\CreateSchoolStudentLis;
use Workdo\ActivityLog\Listeners\CreateSeatingTemplateLis;
use Workdo\ActivityLog\Listeners\CreateServiceLis;
use Workdo\ActivityLog\Listeners\CreateSideMenuBuilderLis;
use Workdo\ActivityLog\Listeners\CreateSpreadsheetLis;
use Workdo\ActivityLog\Listeners\CreateSubjectLis;
use Workdo\ActivityLog\Listeners\CreateSupplierLis;
use Workdo\ActivityLog\Listeners\CreateTaskLis;
use Workdo\ActivityLog\Listeners\CreateTemplateLis;
use Workdo\ActivityLog\Listeners\CreateTenantLis;
use Workdo\ActivityLog\Listeners\CreateTerminationLis;
use Workdo\ActivityLog\Listeners\CreateTicketLis;
use Workdo\ActivityLog\Listeners\CreateTimesheetLis;
use Workdo\ActivityLog\Listeners\CreateTimetableLis;
use Workdo\ActivityLog\Listeners\CreateToDoLis;
use Workdo\ActivityLog\Listeners\CreateTourBookingLis;
use Workdo\ActivityLog\Listeners\CreateTourInquiryLis;
use Workdo\ActivityLog\Listeners\CreateTourLis;
use Workdo\ActivityLog\Listeners\CreateTrainerLis;
use Workdo\ActivityLog\Listeners\CreateTrainingLis;
use Workdo\ActivityLog\Listeners\CreateTransferLis;
use Workdo\ActivityLog\Listeners\CreateTripLis;
use Workdo\ActivityLog\Listeners\CreateTvStudioBlogLis;
use Workdo\ActivityLog\Listeners\CreateTvStudioContentLis;
use Workdo\ActivityLog\Listeners\CreateTvStudioContentOrderLis;
use Workdo\ActivityLog\Listeners\CreateTvStudioCouponLis;
use Workdo\ActivityLog\Listeners\CreateTvStudioCustomPageLis;
use Workdo\ActivityLog\Listeners\CreateTvStudioCustomerLis;
use Workdo\ActivityLog\Listeners\CreateTvStudioPlaylistLis;
use Workdo\ActivityLog\Listeners\CreateUserLis;
use Workdo\ActivityLog\Listeners\CreateVehicleBookingLis;
use Workdo\ActivityLog\Listeners\CreateVehicleLis;
use Workdo\ActivityLog\Listeners\CreateVehicleRouteLis;
use Workdo\ActivityLog\Listeners\CreateVendorLis;
use Workdo\ActivityLog\Listeners\CreateVideoHubCommentLis;
use Workdo\ActivityLog\Listeners\CreateVideoHubVideoLis;
use Workdo\ActivityLog\Listeners\CreateVisitReasonLis;
use Workdo\ActivityLog\Listeners\CreateVisitorLogLis;
use Workdo\ActivityLog\Listeners\CreateWarehouseLis;
use Workdo\ActivityLog\Listeners\CreateWarningLis;
use Workdo\ActivityLog\Listeners\CreateWeightLis;
use Workdo\ActivityLog\Listeners\CreateWorkflowLis;
use Workdo\ActivityLog\Listeners\CreateWorkorderLis;
use Workdo\ActivityLog\Listeners\CreateWorkoutPlanLis;
use Workdo\ActivityLog\Listeners\CreateWorkrequestLis;
use Workdo\ActivityLog\Listeners\CreateZoommeetingLis;
use Workdo\ActivityLog\Listeners\CretaeRepairInvoiceLis;
use Workdo\ActivityLog\Listeners\DealAddCallLis;
use Workdo\ActivityLog\Listeners\DealAddClientLis;
use Workdo\ActivityLog\Listeners\DealAddDiscussionLis;
use Workdo\ActivityLog\Listeners\DealAddEmailLis;
use Workdo\ActivityLog\Listeners\DealAddNoteLis;
use Workdo\ActivityLog\Listeners\DealAddProductLis;
use Workdo\ActivityLog\Listeners\DealAddUserLis;
use Workdo\ActivityLog\Listeners\DealCallUpdateLis;
use Workdo\ActivityLog\Listeners\DealMovedLis;
use Workdo\ActivityLog\Listeners\DealSourceUpdateLis;
use Workdo\ActivityLog\Listeners\DealUploadFileLis;
use Workdo\ActivityLog\Listeners\DuplicateBillLis;
use Workdo\ActivityLog\Listeners\DuplicateBookingsPackageLis;
use Workdo\ActivityLog\Listeners\DuplicateInvoiceLis;
use Workdo\ActivityLog\Listeners\DuplicateProposalLis;
use Workdo\ActivityLog\Listeners\DuplicateRentalLis;
use Workdo\ActivityLog\Listeners\FormBuilderConvertToLis;
use Workdo\ActivityLog\Listeners\HospitalAppointmentStatusLis;
use Workdo\ActivityLog\Listeners\InquiryStatusChangeLis;
use Workdo\ActivityLog\Listeners\InvoicePaymentLis;
use Workdo\ActivityLog\Listeners\JobApplicationArchiveLis;
use Workdo\ActivityLog\Listeners\JobApplicationChangeOrderLis;
use Workdo\ActivityLog\Listeners\LaundryRequestCreateLis;
use Workdo\ActivityLog\Listeners\LaundryRequestUpdateLis;
use Workdo\ActivityLog\Listeners\LeadAddCallLis;
use Workdo\ActivityLog\Listeners\LeadAddDiscussionLis;
use Workdo\ActivityLog\Listeners\LeadAddEmailLis;
use Workdo\ActivityLog\Listeners\LeadAddNoteLis;
use Workdo\ActivityLog\Listeners\LeadAddProductLis;
use Workdo\ActivityLog\Listeners\LeadAddUserLis;
use Workdo\ActivityLog\Listeners\LeadConvertDealLis;
use Workdo\ActivityLog\Listeners\LeadMovedLis;
use Workdo\ActivityLog\Listeners\LeadSourceUpdateLis;
use Workdo\ActivityLog\Listeners\LeadUpdateCallLis;
use Workdo\ActivityLog\Listeners\LeadUploadFileLis;
use Workdo\ActivityLog\Listeners\LeaveStatusLis;
use Workdo\ActivityLog\Listeners\LundaryRequestInvoiceCreateLis;
use Workdo\ActivityLog\Listeners\ManualpaymentdatastoreLis;
use Workdo\ActivityLog\Listeners\ManualpaymentdataupdateLis;
use Workdo\ActivityLog\Listeners\MedicineCreateLis;
use Workdo\ActivityLog\Listeners\MedicineUpdateLis;
use Workdo\ActivityLog\Listeners\MobileServiceCreateLis;
use Workdo\ActivityLog\Listeners\MobileServicePendingRequestAcceptLis;
use Workdo\ActivityLog\Listeners\MobileServicePendingRequestRejectLis;
use Workdo\ActivityLog\Listeners\MobileServiceUpdateLis;
use Workdo\ActivityLog\Listeners\PaymentReminderInvoiceLis;
use Workdo\ActivityLog\Listeners\PayslipSendLis;
use Workdo\ActivityLog\Listeners\PharmacyBillCreateLis;
use Workdo\ActivityLog\Listeners\PharmacyBillUpdateLis;
use Workdo\ActivityLog\Listeners\PharmacyInvoiceCreateLis;
use Workdo\ActivityLog\Listeners\PharmacyInvoicePaymentCreateLis;
use Workdo\ActivityLog\Listeners\PharmacyInvoiceUpdateLis;
use Workdo\ActivityLog\Listeners\PortfolioCategoryCreateLis;
use Workdo\ActivityLog\Listeners\ProjectInviteUserLis;
use Workdo\ActivityLog\Listeners\ProjectShareToClientLis;
use Workdo\ActivityLog\Listeners\ProjectUploadFilesLis;
use Workdo\ActivityLog\Listeners\QuoteDuplicateLis;
use Workdo\ActivityLog\Listeners\ResentBillLis;
use Workdo\ActivityLog\Listeners\ResentInvoiceLis;
use Workdo\ActivityLog\Listeners\ResentProposalLis;
use Workdo\ActivityLog\Listeners\ResentPurchaseLis;
use Workdo\ActivityLog\Listeners\ResentRetainerLis;
use Workdo\ActivityLog\Listeners\RetainerConvertToInvoiceLis;
use Workdo\ActivityLog\Listeners\RetainerDuplicateLis;
use Workdo\ActivityLog\Listeners\SalesAgentCreateLis;
use Workdo\ActivityLog\Listeners\SalesAgentProgramCreateLis;
use Workdo\ActivityLog\Listeners\SalesAgentProgramUpdateLis;
use Workdo\ActivityLog\Listeners\SalesAgentUpdateLis;
use Workdo\ActivityLog\Listeners\SalesInvoiceItemDuplicateLis;
use Workdo\ActivityLog\Listeners\SalesOrderDuplicateLis;
use Workdo\ActivityLog\Listeners\SendMailContractLis;
use Workdo\ActivityLog\Listeners\SendRotasViaEmailLis;
use Workdo\ActivityLog\Listeners\SentBillLis;
use Workdo\ActivityLog\Listeners\SentInvoiceLis;
use Workdo\ActivityLog\Listeners\SentProposalLis;
use Workdo\ActivityLog\Listeners\SentPurchaseLis;
use Workdo\ActivityLog\Listeners\SentRetainerLis;
use Workdo\ActivityLog\Listeners\StatusChangeDealTaskLis;
use Workdo\ActivityLog\Listeners\StatusChangeProposalLis;
use Workdo\ActivityLog\Listeners\StatusChangeRoomBookingLis;
use Workdo\ActivityLog\Listeners\UpdateAccessoriesLis;
use Workdo\ActivityLog\Listeners\UpdateAdmissionLis;
use Workdo\ActivityLog\Listeners\UpdateAdvocateLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureActivitiesLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureCanalLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureClaimTypeLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureCropLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureCultivationLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureCyclesLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureDepartmentLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureEquipmentLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureOfficesLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureProcessLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureSeasonLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureSeasonTypeLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureServiceProductLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureServicesLis;
use Workdo\ActivityLog\Listeners\UpdateAgricultureUserLis;
use Workdo\ActivityLog\Listeners\UpdateAgriculturefleetLis;
use Workdo\ActivityLog\Listeners\UpdateAllowanceLis;
use Workdo\ActivityLog\Listeners\UpdateAnimalLis;
use Workdo\ActivityLog\Listeners\UpdateAnnouncementLis;
use Workdo\ActivityLog\Listeners\UpdateAppointmentLis;
use Workdo\ActivityLog\Listeners\UpdateAppraisalLis;
use Workdo\ActivityLog\Listeners\UpdateArticleLis;
use Workdo\ActivityLog\Listeners\UpdateAssetLis;
use Workdo\ActivityLog\Listeners\UpdateAssetsLis;
use Workdo\ActivityLog\Listeners\UpdateAuditLis;
use Workdo\ActivityLog\Listeners\UpdateAvailabilityLis;
use Workdo\ActivityLog\Listeners\UpdateAwardLis;
use Workdo\ActivityLog\Listeners\UpdateBankAccountLis;
use Workdo\ActivityLog\Listeners\UpdateBankTransferLis;
use Workdo\ActivityLog\Listeners\UpdateBeautyBookingLis;
use Workdo\ActivityLog\Listeners\UpdateBeautyServiceLis;
use Workdo\ActivityLog\Listeners\UpdateBillLis;
use Workdo\ActivityLog\Listeners\UpdateBillOfMaterialLis;
use Workdo\ActivityLog\Listeners\UpdateBlogLis;
use Workdo\ActivityLog\Listeners\UpdateBookLis;
use Workdo\ActivityLog\Listeners\UpdateBookingCouponLis;
use Workdo\ActivityLog\Listeners\UpdateBookingLis;
use Workdo\ActivityLog\Listeners\UpdateBookingsAppointmentLis;
use Workdo\ActivityLog\Listeners\UpdateBookingsCustomerLis;
use Workdo\ActivityLog\Listeners\UpdateBookingsPackageLis;
use Workdo\ActivityLog\Listeners\UpdateBookingsStaffLis;
use Workdo\ActivityLog\Listeners\UpdateBreedingLis;
use Workdo\ActivityLog\Listeners\UpdateBugLis;
use Workdo\ActivityLog\Listeners\UpdateBugStageLis;
use Workdo\ActivityLog\Listeners\UpdateBulkAttendanceLis;
use Workdo\ActivityLog\Listeners\UpdateBusinessLis;
use Workdo\ActivityLog\Listeners\UpdateBusinessModelLis;
use Workdo\ActivityLog\Listeners\UpdateBusinessPlanLis;
use Workdo\ActivityLog\Listeners\UpdateBusinessProcessMappingLis;
use Workdo\ActivityLog\Listeners\UpdateCallLis;
use Workdo\ActivityLog\Listeners\UpdateCallListLis;
use Workdo\ActivityLog\Listeners\UpdateCallhubAdavanceLis;
use Workdo\ActivityLog\Listeners\UpdateCarPurchaseLis;
use Workdo\ActivityLog\Listeners\UpdateCarSaleLis;
use Workdo\ActivityLog\Listeners\UpdateCaseInitiatorLis;
use Workdo\ActivityLog\Listeners\UpdateCaseLis;
use Workdo\ActivityLog\Listeners\UpdateCateringCustomerLis;
use Workdo\ActivityLog\Listeners\UpdateChallengeLis;
use Workdo\ActivityLog\Listeners\UpdateCharterLis;
use Workdo\ActivityLog\Listeners\UpdateChildAttendanceLis;
use Workdo\ActivityLog\Listeners\UpdateChildBulkAttendanceLis;
use Workdo\ActivityLog\Listeners\UpdateChildLis;
use Workdo\ActivityLog\Listeners\UpdateClassroomLis;
use Workdo\ActivityLog\Listeners\UpdateCleaningBookingLis;
use Workdo\ActivityLog\Listeners\UpdateCleaningTeamLis;
use Workdo\ActivityLog\Listeners\UpdateCollectionCenterLis;
use Workdo\ActivityLog\Listeners\UpdateCommissionLis;
use Workdo\ActivityLog\Listeners\UpdateCommissionPlanLis;
use Workdo\ActivityLog\Listeners\UpdateCommonCaseLis;
use Workdo\ActivityLog\Listeners\UpdateCompanyPolicyLis;
use Workdo\ActivityLog\Listeners\UpdateComplaintLis;
use Workdo\ActivityLog\Listeners\UpdateConsignmentLis;
use Workdo\ActivityLog\Listeners\UpdateConsignmentProductLis;
use Workdo\ActivityLog\Listeners\UpdateConsumablesLis;
use Workdo\ActivityLog\Listeners\UpdateContactLis;
use Workdo\ActivityLog\Listeners\UpdateCourseCouponLis;
use Workdo\ActivityLog\Listeners\UpdateCourseLis;
use Workdo\ActivityLog\Listeners\UpdateCourtLis;
use Workdo\ActivityLog\Listeners\UpdateCreativityLis;
use Workdo\ActivityLog\Listeners\UpdateCustomFieldLis;
use Workdo\ActivityLog\Listeners\UpdateCustomPageLis;
use Workdo\ActivityLog\Listeners\UpdateCustomQuestionLis;
use Workdo\ActivityLog\Listeners\UpdateCustomerLis;
use Workdo\ActivityLog\Listeners\UpdateDailyMilkSheetLis;
use Workdo\ActivityLog\Listeners\UpdateDealLis;
use Workdo\ActivityLog\Listeners\UpdateDealTaskLis;
use Workdo\ActivityLog\Listeners\UpdateDealershipProductLis;
use Workdo\ActivityLog\Listeners\UpdateDefectsAndRepairsLis;
use Workdo\ActivityLog\Listeners\UpdateDiagnosisLis;
use Workdo\ActivityLog\Listeners\UpdateDiningTableLis;
use Workdo\ActivityLog\Listeners\UpdateDivisionLis;
use Workdo\ActivityLog\Listeners\UpdateDoctorLis;
use Workdo\ActivityLog\Listeners\UpdateDocumentLis;
use Workdo\ActivityLog\Listeners\UpdateDocumentTypeLis;
use Workdo\ActivityLog\Listeners\UpdateDriverLis;
use Workdo\ActivityLog\Listeners\UpdateDrivingClassLis;
use Workdo\ActivityLog\Listeners\UpdateDrivingInvoiceLis;
use Workdo\ActivityLog\Listeners\UpdateDrivingStudentLis;
use Workdo\ActivityLog\Listeners\UpdateDrivingVehicleLis;
use Workdo\ActivityLog\Listeners\UpdateEmployeeLis;
use Workdo\ActivityLog\Listeners\UpdateEmployeeSalaryLis;
use Workdo\ActivityLog\Listeners\UpdateEventDetailLis;
use Workdo\ActivityLog\Listeners\UpdateEventLis;
use Workdo\ActivityLog\Listeners\UpdateExpenseLis;
use Workdo\ActivityLog\Listeners\UpdateFeeLis;
use Workdo\ActivityLog\Listeners\UpdateFeeRecieptLis;
use Workdo\ActivityLog\Listeners\UpdateFeeRecieveLis;
use Workdo\ActivityLog\Listeners\UpdateFileLis;
use Workdo\ActivityLog\Listeners\UpdateFinacialGoalLis;
use Workdo\ActivityLog\Listeners\UpdateFixComponentLis;
use Workdo\ActivityLog\Listeners\UpdateFleetCustomerLis;
use Workdo\ActivityLog\Listeners\UpdateFormFieldLis;
use Workdo\ActivityLog\Listeners\UpdateFormLis;
use Workdo\ActivityLog\Listeners\UpdateFreightBookingRequestLis;
use Workdo\ActivityLog\Listeners\UpdateFreightCustomerLis;
use Workdo\ActivityLog\Listeners\UpdateFuelLis;
use Workdo\ActivityLog\Listeners\UpdateGarageVehicleLis;
use Workdo\ActivityLog\Listeners\UpdateGoalTrackingLis;
use Workdo\ActivityLog\Listeners\UpdateGymMemberLis;
use Workdo\ActivityLog\Listeners\UpdateGymTrainerLis;
use Workdo\ActivityLog\Listeners\UpdateHealthLis;
use Workdo\ActivityLog\Listeners\UpdateHighCourtLis;
use Workdo\ActivityLog\Listeners\UpdateHolidaysLis;
use Workdo\ActivityLog\Listeners\UpdateHospitalAppointmentLis;
use Workdo\ActivityLog\Listeners\UpdateHospitalBedLis;
use Workdo\ActivityLog\Listeners\UpdateHospitalMedicineLis;
use Workdo\ActivityLog\Listeners\UpdateHotelCustomerLis;
use Workdo\ActivityLog\Listeners\UpdateHotelServiceLis;
use Workdo\ActivityLog\Listeners\UpdateIndicatorLis;
use Workdo\ActivityLog\Listeners\UpdateInquiryLis;
use Workdo\ActivityLog\Listeners\UpdateInspectionListLis;
use Workdo\ActivityLog\Listeners\UpdateInspectionRequestLis;
use Workdo\ActivityLog\Listeners\UpdateInspectionVehicleLis;
use Workdo\ActivityLog\Listeners\UpdateInsuranceLis;
use Workdo\ActivityLog\Listeners\UpdateInterviewScheduleLis;
use Workdo\ActivityLog\Listeners\UpdateInvoiceLis;
use Workdo\ActivityLog\Listeners\UpdateJobBoardLis;
use Workdo\ActivityLog\Listeners\UpdateJobCandidateLis;
use Workdo\ActivityLog\Listeners\UpdateJobLis;
use Workdo\ActivityLog\Listeners\UpdateJournalAccountLis;
use Workdo\ActivityLog\Listeners\UpdateLabPatientLis;
use Workdo\ActivityLog\Listeners\UpdateLabRequestLis;
use Workdo\ActivityLog\Listeners\UpdateLeadLis;
use Workdo\ActivityLog\Listeners\UpdateLeaveLis;
use Workdo\ActivityLog\Listeners\UpdateLicenceLis;
use Workdo\ActivityLog\Listeners\UpdateLoanLis;
use Workdo\ActivityLog\Listeners\UpdateLocationLis;
use Workdo\ActivityLog\Listeners\UpdateMachineLis;
use Workdo\ActivityLog\Listeners\UpdateMaintenanceLis;
use Workdo\ActivityLog\Listeners\UpdateMaintenanceRequestLis;
use Workdo\ActivityLog\Listeners\UpdateMaintenancesLis;
use Workdo\ActivityLog\Listeners\UpdateManufacturingLis;
use Workdo\ActivityLog\Listeners\UpdateMarkAttendanceLis;
use Workdo\ActivityLog\Listeners\UpdateMarketingPlanLis;
use Workdo\ActivityLog\Listeners\UpdateMcKinseyModelLis;
use Workdo\ActivityLog\Listeners\UpdateMeasurementLis;
use Workdo\ActivityLog\Listeners\UpdateMedicalAppoinmentLis;
use Workdo\ActivityLog\Listeners\UpdateMedicalRecordsLis;
use Workdo\ActivityLog\Listeners\UpdateMeeingHubMeetingLis;
use Workdo\ActivityLog\Listeners\UpdateMeeingHubMeetingTypeLis;
use Workdo\ActivityLog\Listeners\UpdateMeetingLis;
use Workdo\ActivityLog\Listeners\UpdateMembershipPlanLis;
use Workdo\ActivityLog\Listeners\UpdateMenuSelectionLis;
use Workdo\ActivityLog\Listeners\UpdateMilestoneLis;
use Workdo\ActivityLog\Listeners\UpdateMilkInventoryLis;
use Workdo\ActivityLog\Listeners\UpdateMilkProductLis;
use Workdo\ActivityLog\Listeners\UpdateMonthlyPayslipLis;
use Workdo\ActivityLog\Listeners\UpdateMovieCastLis;
use Workdo\ActivityLog\Listeners\UpdateMovieShowLis;
use Workdo\ActivityLog\Listeners\UpdateMusicClassLis;
use Workdo\ActivityLog\Listeners\UpdateMusicInstrumentLis;
use Workdo\ActivityLog\Listeners\UpdateMusicStudentLis;
use Workdo\ActivityLog\Listeners\UpdateMusicTeacherLis;
use Workdo\ActivityLog\Listeners\UpdateNewspaperAdsLis;
use Workdo\ActivityLog\Listeners\UpdateNewspaperAgentLis;
use Workdo\ActivityLog\Listeners\UpdateNewspaperDistributionsLis;
use Workdo\ActivityLog\Listeners\UpdateNewspaperInvoiceLis;
use Workdo\ActivityLog\Listeners\UpdateNewspaperJournalistInfoLis;
use Workdo\ActivityLog\Listeners\UpdateNewspaperJournalistLis;
use Workdo\ActivityLog\Listeners\UpdateNewspaperLis;
use Workdo\ActivityLog\Listeners\UpdateNotesLis;
use Workdo\ActivityLog\Listeners\UpdateOpportunitiesLis;
use Workdo\ActivityLog\Listeners\UpdateOtherPaymentLis;
use Workdo\ActivityLog\Listeners\UpdateOvertimeLis;
use Workdo\ActivityLog\Listeners\UpdatePESTAnalysisModelLis;
use Workdo\ActivityLog\Listeners\UpdatePESTELAnalysisModelLis;
use Workdo\ActivityLog\Listeners\UpdatePackagingLis;
use Workdo\ActivityLog\Listeners\UpdatePageOptionLis;
use Workdo\ActivityLog\Listeners\UpdateParentLis;
use Workdo\ActivityLog\Listeners\UpdatePatientCardLis;
use Workdo\ActivityLog\Listeners\UpdatePatientLis;
use Workdo\ActivityLog\Listeners\UpdatePaymentLis;
use Workdo\ActivityLog\Listeners\UpdatePlanningChallengeLis;
use Workdo\ActivityLog\Listeners\UpdatePortersFiveForcesModeLis;
use Workdo\ActivityLog\Listeners\UpdatePortfolioCategoryLis;
use Workdo\ActivityLog\Listeners\UpdatePortfolioLis;
use Workdo\ActivityLog\Listeners\UpdatePreDefinedKitLis;
use Workdo\ActivityLog\Listeners\UpdateProductLis;
use Workdo\ActivityLog\Listeners\UpdateProjectLis;
use Workdo\ActivityLog\Listeners\UpdatePromotionLis;
use Workdo\ActivityLog\Listeners\UpdatePropertyLis;
use Workdo\ActivityLog\Listeners\UpdatePropertyUnitLis;
use Workdo\ActivityLog\Listeners\UpdateProposalLis;
use Workdo\ActivityLog\Listeners\UpdatePurchaseLis;
use Workdo\ActivityLog\Listeners\UpdatePurchaseOrderLis;
use Workdo\ActivityLog\Listeners\UpdateQuestionLis;
use Workdo\ActivityLog\Listeners\UpdateQuotationLis;
use Workdo\ActivityLog\Listeners\UpdateQuoteLis;
use Workdo\ActivityLog\Listeners\UpdateRawMaterialLis;
use Workdo\ActivityLog\Listeners\UpdateReminderLis;
use Workdo\ActivityLog\Listeners\UpdateRentalLis;
use Workdo\ActivityLog\Listeners\UpdateRepairOrderRequestLis;
use Workdo\ActivityLog\Listeners\UpdateRepairPartLis;
use Workdo\ActivityLog\Listeners\UpdateRepairRequestLis;
use Workdo\ActivityLog\Listeners\UpdateRequestsLis;
use Workdo\ActivityLog\Listeners\UpdateResignationLis;
use Workdo\ActivityLog\Listeners\UpdateRestaurantCustomerLis;
use Workdo\ActivityLog\Listeners\UpdateRetainerLis;
use Workdo\ActivityLog\Listeners\UpdateRevenueLis;
use Workdo\ActivityLog\Listeners\UpdateRoadmapIdeasLis;
use Workdo\ActivityLog\Listeners\UpdateRoadmapLis;
use Workdo\ActivityLog\Listeners\UpdateRoomBookingLis;
use Workdo\ActivityLog\Listeners\UpdateRoomFacilityLis;
use Workdo\ActivityLog\Listeners\UpdateRoomFeatureLis;
use Workdo\ActivityLog\Listeners\UpdateRoomLis;
use Workdo\ActivityLog\Listeners\UpdateRotaLis;
use Workdo\ActivityLog\Listeners\UpdateSWOTAnalysismodelLis;
use Workdo\ActivityLog\Listeners\UpdateSaleOrderLis;
use Workdo\ActivityLog\Listeners\UpdateSalesAccountLis;
use Workdo\ActivityLog\Listeners\UpdateSalesDocumentLis;
use Workdo\ActivityLog\Listeners\UpdateSalesInvoiceLis;
use Workdo\ActivityLog\Listeners\UpdateSalesOrderLis;
use Workdo\ActivityLog\Listeners\UpdateSaturationDeductionLis;
use Workdo\ActivityLog\Listeners\UpdateSchoolHomeworkLis;
use Workdo\ActivityLog\Listeners\UpdateSchoolParentLis;
use Workdo\ActivityLog\Listeners\UpdateSchoolStudentLis;
use Workdo\ActivityLog\Listeners\UpdateSeatingTemplateLis;
use Workdo\ActivityLog\Listeners\UpdateServiceLis;
use Workdo\ActivityLog\Listeners\UpdateSideMenuBuilderLis;
use Workdo\ActivityLog\Listeners\UpdateSpreadsheetLis;
use Workdo\ActivityLog\Listeners\UpdateSubjectLis;
use Workdo\ActivityLog\Listeners\UpdateTaskLis;
use Workdo\ActivityLog\Listeners\UpdateTaskStageLis;
use Workdo\ActivityLog\Listeners\UpdateTemplateLis;
use Workdo\ActivityLog\Listeners\UpdateTenantLis;
use Workdo\ActivityLog\Listeners\UpdateTerminationLis;
use Workdo\ActivityLog\Listeners\UpdateTicketLis;
use Workdo\ActivityLog\Listeners\UpdateTimesheetLis;
use Workdo\ActivityLog\Listeners\UpdateTimetableLis;
use Workdo\ActivityLog\Listeners\UpdateToDoLis;
use Workdo\ActivityLog\Listeners\UpdateTourInquiryLis;
use Workdo\ActivityLog\Listeners\UpdateTourLis;
use Workdo\ActivityLog\Listeners\UpdateTrainerLis;
use Workdo\ActivityLog\Listeners\UpdateTrainingLis;
use Workdo\ActivityLog\Listeners\UpdateTransferLis;
use Workdo\ActivityLog\Listeners\UpdateTripLis;
use Workdo\ActivityLog\Listeners\UpdateTvStudioBlogLis;
use Workdo\ActivityLog\Listeners\UpdateTvStudioContentLis;
use Workdo\ActivityLog\Listeners\UpdateTvStudioCouponLis;
use Workdo\ActivityLog\Listeners\UpdateTvStudioCustomPageLis;
use Workdo\ActivityLog\Listeners\UpdateTvStudioCustomerLis;
use Workdo\ActivityLog\Listeners\UpdateTvStudioPlaylistLis;
use Workdo\ActivityLog\Listeners\UpdateUserLis;
use Workdo\ActivityLog\Listeners\UpdateVehicleLis;
use Workdo\ActivityLog\Listeners\UpdateVehicleRouteLis;
use Workdo\ActivityLog\Listeners\UpdateVendorLis;
use Workdo\ActivityLog\Listeners\UpdateVideoHubVideoLis;
use Workdo\ActivityLog\Listeners\UpdateVisitReasonLis;
use Workdo\ActivityLog\Listeners\UpdateVisitorLogLis;
use Workdo\ActivityLog\Listeners\UpdateWarehouseLis;
use Workdo\ActivityLog\Listeners\UpdateWarningLis;
use Workdo\ActivityLog\Listeners\UpdateWeightLis;
use Workdo\ActivityLog\Listeners\UpdateWorkScheduleLis;
use Workdo\ActivityLog\Listeners\UpdateWorkflowLis;
use Workdo\ActivityLog\Listeners\UpdateWorkingHoursLis;
use Workdo\ActivityLog\Listeners\UpdateWorkoutPlanLis;
use Workdo\ActivityLog\Listeners\UpdatecontractLis;
use Workdo\ActivityLog\Listeners\VcardCreateAppointmentLis;
use Workdo\ActivityLog\Listeners\VcardCreateContactLis;
use Workdo\ActivityLog\Listeners\VcardUpdateAppointmentLis;
use Workdo\ActivityLog\Listeners\VcardUpdateContactLis;
use Workdo\ActivityLog\Listeners\ViewFormLis;
use Workdo\ActivityLog\Listeners\WasteCollectionRequestCreateLis;
use Workdo\ActivityLog\Listeners\WasteCollectionRequestUpdateLis;
use Workdo\ActivityLog\Listeners\WastecollectionConvertedToTripLis;
use Workdo\ActivityLog\Listeners\ConvertIntoLeadSettingLis;
use Workdo\ActivityLog\Listeners\CreatePaymentBillLis;
use Workdo\ActivityLog\Listeners\CreatePaymentPurchaseLis;
use Workdo\ActivityLog\Listeners\CreatePaymentRetainerLis;
use Workdo\ActivityLog\Listeners\CreateRevenueLis;
use Workdo\ActivityLog\Listeners\ImageGeneratLis;
use Workdo\ActivityLog\Listeners\UpdateCmmsposLis;
use Workdo\ActivityLog\Listeners\UpdateComponentLis;
use Workdo\ActivityLog\Listeners\UpdateHistoryLis;
use Workdo\ActivityLog\Listeners\UpdatePartLis;
use Workdo\ActivityLog\Listeners\UpdatePmsLis;
use Workdo\ActivityLog\Listeners\UpdateStatusLis;
use Workdo\ActivityLog\Listeners\UpdateSupplierLis;
use Workdo\ActivityLog\Listeners\UpdateWorkorderLis;
use Workdo\Retainer\Events\SentRetainer;
use Workdo\Taskly\Events\Updateproject;

class EventServiceProvider extends Provider
{
    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    protected $listen = [
        AddDayoff::class => [
            AddDayoffLis::class
        ],
        AdmissionConvert::class => [
            AdmissionConvertLis::class
        ],
        AppointmentStatus::class => [
            AppointmentStatusLis::class
        ],
        BusinessStatus::class => [
            BusinessStatusLis::class
        ],
        ChangeStatusCleaningBookingRequest::class => [
            ChangeStatusCleaningBookingRequestLis::class
        ],
        ChangeStatusNewspaperInvoice::class => [
            ChangeStatusNewspaperInvoiceLis::class
        ],
        CompanyMenuEvent::class => [
            CompanyMenuListener::class
        ],
        ConvertToEmployee::class => [
            ConvertToEmployeeLis::class
        ],
        ConvertToInvoice::class => [
            ConvertToInvoiceLis::class
        ],
        CopyContract::class => [
            CopyContractLis::class
        ],
        Couriercreate::class => [
            CouriercreateLis::class
        ],
        Courierupdate::class => [
            CourierupdateLis::class
        ],
        CreateAccessories::class => [
            CreateAccessoriesLis::class
        ],
        CreateAdmission::class => [
            CreateAdmissionLis::class
        ],
        CreateAdvocate::class => [
            CreateAdvocateLis::class
        ],
        CreateAgricultureActivities::class => [
            CreateAgricultureActivitiesLis::class
        ],
        CreateAgricultureCanal::class => [
            CreateAgricultureCanalLis::class
        ],
        CreateAgricultureClaimType::class => [
            CreateAgricultureClaimTypeLis::class
        ],
        CreateAgricultureCrop::class => [
            CreateAgricultureCropLis::class
        ],
        CreateAgricultureCultivation::class => [
            CreateAgricultureCultivationLis::class
        ],
        CreateAgricultureCycles::class => [
            CreateAgricultureCyclesLis::class
        ],
        CreateAgricultureDepartment::class => [
            CreateAgricultureDepartmentLis::class
        ],
        CreateAgricultureEquipment::class => [
            CreateAgricultureEquipmentLis::class
        ],
        CreateAgricultureOffices::class => [
            CreateAgricultureOfficesLis::class
        ],
        CreateAgricultureProcess::class => [
            CreateAgricultureProcessLis::class
        ],
        CreateAgricultureSeason::class => [
            CreateAgricultureSeasonLis::class
        ],
        CreateAgricultureSeasonType::class => [
            CreateAgricultureSeasonTypeLis::class
        ],
        CreateAgricultureServiceProduct::class => [
            CreateAgricultureServiceProductLis::class
        ],
        CreateAgricultureServices::class => [
            CreateAgricultureServicesLis::class
        ],
        CreateAgricultureUser::class => [
            CreateAgricultureUserLis::class
        ],
        CreateAgriculturefleet::class => [
            CreateAgriculturefleetLis::class
        ],
        CreateAllowance::class => [
            CreateAllowanceLis::class
        ],
        CreateAnimal::class => [
            CreateAnimalLis::class
        ],
        CreateAnnouncement::class => [
            CreateAnnouncementLis::class
        ],
        CreateAppointment::class => [
            CreateAppointmentLis::class
        ],
        CreateAppointments::class => [
            CreateAppointmentsLis::class
        ],
        CreateAppraisal::class => [
            CreateAppraisalLis::class
        ],
        CreateArticle::class => [
            CreateArticleLis::class
        ],
        CreateAsset::class => [
            CreateAssetLis::class
        ],
        CreateAssets::class => [
            CreateAssetsLis::class
        ],
        CreateAudit::class => [
            CreateAuditLis::class
        ],
        CreateAvailability::class => [
            CreateAvailabilityLis::class
        ],
        CreateAward::class => [
            CreateAwardLis::class
        ],
        CreateBankAccount::class => [
            CreateBankAccountLis::class
        ],
        CreateBankTransfer::class => [
            CreateBankTransferLis::class
        ],
        CreateBeautyBooking::class => [
            CreateBeautyBookingLis::class
        ],
        CreateBeautyService::class => [
            CreateBeautyServiceLis::class
        ],
        CreateBill::class => [
            CreateBillLis::class
        ],
        CreateBillOfMaterial::class => [
            CreateBillOfMaterialLis::class
        ],
        CreateBlog::class => [
            CreateBlogLis::class
        ],
        CreateBook::class => [
            CreateBookLis::class
        ],
        CreateBookingCoupon::class => [
            CreateBookingCouponLis::class
        ],
        CreateBooking::class => [
            CreateBookingLis::class
        ],
        CreateBookingsAppointment::class => [
            CreateBookingsAppointmentLis::class
        ],
        CreateBookingsCustomer::class => [
            CreateBookingsCustomerLis::class
        ],
        CreateBookingsPackage::class => [
            CreateBookingsPackageLis::class
        ],
        CreateBookingsStaff::class => [
            CreateBookingsStaffLis::class
        ],
        CreateBreeding::class => [
            CreateBreedingLis::class
        ],
        CreateBug::class => [
            CreateBugLis::class
        ],
        CreateBusiness::class => [
            CreateBusinessLis::class
        ],
        CreateBusinessModel::class => [
            CreateBusinessModelLis::class
        ],
        CreateBusinessPlan::class => [
            CreateBusinessPlanLis::class
        ],
        CreateBusinessProcessMapping::class => [
            CreateBusinessProcessMappingLis::class
        ],
        CreateCall::class => [
            CreateCallLis::class
        ],
        CreateCallList::class => [
            CreateCallListLis::class
        ],
        CreateCallhubAdavance::class => [
            CreateCallhubAdavanceLis::class
        ],
        CreateCarPurchase::class => [
            CreateCarPurchaseLis::class
        ],
        CreateCarSale::class => [
            CreateCarSaleLis::class
        ],
        CreateCaseInitiator::class => [
            CreateCaseInitiatorLis::class
        ],
        CreateCase::class => [
            CreateCaseLis::class
        ],
        CreateCateringCustomer::class => [
            CreateCateringCustomerLis::class
        ],
        CreateCateringInvoice::class => [
            CreateCateringInvoiceLis::class
        ],
        CreateChallenge::class => [
            CreateChallengeLis::class
        ],
        CreateChangeOrder::class => [
            CreateChangeOrderLis::class
        ],
        CreateCharter::class => [
            CreateCharterLis::class
        ],
        CreateChildAttendance::class => [
            CreateChildAttendanceLis::class
        ],
        CreateChild::class => [
            CreateChildLis::class
        ],
        CreateClassroom::class => [
            CreateClassroomLis::class
        ],
        CreateCleaningBooking::class => [
            CreateCleaningBookingLis::class
        ],
        CreateCleaningTeam::class => [
            CreateCleaningTeamLis::class
        ],
        CreateCmmspos::class => [
            CreateCmmsposLis::class
        ],
        CreateCollectionCenter::class => [
            CreateCollectionCenterLis::class
        ],
        CreateCommission::class => [
            CreateCommissionLis::class
        ],
        CreateCommissionPlan::class => [
            CreateCommissionPlanLis::class
        ],
        CreateCommissionReceipt::class => [
            CreateCommissionReceiptLis::class
        ],
        CreateCommonCase::class => [
            CreateCommonCaseLis::class
        ],
        CreateCompanyPolicy::class => [
            CreateCompanyPolicyLis::class
        ],
        CreateComplaint::class => [
            CreateComplaintLis::class
        ],
        CreateComponent::class => [
            CreateComponentLis::class
        ],
        CreateConsignment::class => [
            CreateConsignmentLis::class
        ],
        CreateConsignmentProduct::class => [
            CreateConsignmentProductLis::class
        ],
        CreateConsumables::class => [
            CreateConsumablesLis::class
        ],
        CreateContact::class => [
            CreateContactLis::class
        ],
        CreateContract::class => [
            CreateContractLis::class
        ],
        CreateCourseCoupon::class => [
            CreateCourseCouponLis::class
        ],
        CreateCourse::class => [
            CreateCourseLis::class
        ],
        CreateCourt::class => [
            CreateCourtLis::class
        ],
        CreateCreativity::class => [
            CreateCreativityLis::class
        ],
        CreateCustomField::class => [
            CreateCustomFieldLis::class
        ],
        CreateCustomPage::class => [
            CreateCustomPageLis::class
        ],
        CreateCustomQuestion::class => [
            CreateCustomQuestionLis::class
        ],
        CreateCustomer::class => [
            CreateCustomerLis::class
        ],
        CreateDailyMilkSheet::class => [
            CreateDailyMilkSheetLis::class
        ],
        CreateDeal::class => [
            CreateDealLis::class
        ],
        CreateDealTask::class => [
            CreateDealTaskLis::class
        ],
        CreateDealershipProduct::class => [
            CreateDealershipProductLis::class
        ],
        CreateDefectsAndRepairs::class => [
            CreateDefectsAndRepairsLis::class
        ],
        CreateDiagnosis::class => [
            CreateDiagnosisLis::class
        ],
        CreateDiningTable::class => [
            CreateDiningTableLis::class
        ],
        CreateDivision::class => [
            CreateDivisionLis::class
        ],
        CreateDoctor::class => [
            CreateDoctorLis::class
        ],
        CreateDocument::class => [
            CreateDocumentLis::class
        ],
        CreateDocumentType::class => [
            CreateDocumentTypeLis::class
        ],
        CreateDriver::class => [
            CreateDriverLis::class
        ],
        CreateDrivingClass::class => [
            CreateDrivingClassLis::class
        ],
        CreateDrivingInvoice::class => [
            CreateDrivingInvoiceLis::class
        ],
        CreateDrivingStudent::class => [
            CreateDrivingStudentLis::class
        ],
        CreateDrivingVehicle::class => [
            CreateDrivingVehicleLis::class
        ],
        CreateEmployee::class => [
            CreateEmployeeLis::class
        ],
        CreateEventDetail::class => [
            CreateEventDetailLis::class
        ],
        CreateEvent::class => [
            CreateEventLis::class
        ],
        CreateExpense::class => [
            CreateExpenseLis::class
        ],
        CreateFee::class => [
            CreateFeeLis::class
        ],
        CreateFeeReciept::class => [
            CreateFeeRecieptLis::class
        ],
        CreateFeeRecieve::class => [
            CreateFeeRecieveLis::class
        ],
        CreateFile::class => [
            CreateFileLis::class
        ],
        CreateFinacialGoal::class => [
            CreateFinacialGoalLis::class
        ],
        CreateFixComponent::class => [
            CreateFixComponentLis::class
        ],
        CreateFleetCustomer::class => [
            CreateFleetCustomerLis::class
        ],
        CreateFormField::class => [
            CreateFormFieldLis::class
        ],
        CreateForm::class => [
            CreateFormLis::class
        ],
        CreateFreightBookingRequest::class => [
            CreateFreightBookingRequestLis::class
        ],
        CreateFreightCustomer::class => [
            CreateFreightCustomerLis::class
        ],
        CreateFuel::class => [
            CreateFuelLis::class
        ],
        CreateGarageVehicle::class => [
            CreateGarageVehicleLis::class
        ],
        CreateGoalTracking::class => [
            CreateGoalTrackingLis::class
        ],
        CreateGymMember::class => [
            CreateGymMemberLis::class
        ],
        CreateGymTrainer::class => [
            CreateGymTrainerLis::class
        ],
        CreateHealth::class => [
            CreateHealthLis::class
        ],
        CreateHighCourt::class => [
            CreateHighCourtLis::class
        ],
        CreateHolidays::class => [
            CreateHolidaysLis::class
        ],
        CreateHospitalAppointment::class => [
            CreateHospitalAppointmentLis::class
        ],
        CreateHospitalBed::class => [
            CreateHospitalBedLis::class
        ],
        CreateHospitalMedicine::class => [
            CreateHospitalMedicineLis::class
        ],
        CreateHotelCustomer::class => [
            CreateHotelCustomerLis::class
        ],
        CreateHotelService::class => [
            CreateHotelServiceLis::class
        ],
        CreateIndicator::class => [
            CreateIndicatorLis::class
        ],
        CreateInquiry::class => [
            CreateInquiryLis::class
        ],
        CreateInspectionList::class => [
            CreateInspectionListLis::class
        ],
        CreateInspectionRequest::class => [
            CreateInspectionRequestLis::class
        ],
        CreateInspectionVehicle::class => [
            CreateInspectionVehicleLis::class
        ],
        CreateInsurance::class => [
            CreateInsuranceLis::class
        ],
        CreateInterviewSchedule::class => [
            CreateInterviewScheduleLis::class
        ],
        CreateInvoice::class => [
            CreateInvoiceLis::class
        ],
        CreateJobApplicationStageChange::class => [
            CreateJobApplicationStageChangeLis::class
        ],
        CreateJobApplication::class => [
            CreateJobApplicationLis::class
        ],
        CreateJobBoard::class => [
            CreateJobBoardLis::class
        ],
        CreateJobCandidate::class => [
            CreateJobCandidateLis::class
        ],
        CreateJob::class => [
            CreateJobLis::class
        ],
        CreateJournalAccount::class => [
            CreateJournalAccountLis::class
        ],
        CreateLabPatient::class => [
            CreateLabPatientLis::class
        ],
        CreateLabRequest::class => [
            CreateLabRequestLis::class
        ],
        CreateLead::class => [
            CreateLeadLis::class
        ],
        CreateLeave::class => [
            CreateLeaveLis::class
        ],
        CreateLicence::class => [
            CreateLicenceLis::class
        ],
        CreateLoan::class => [
            CreateLoanLis::class
        ],
        CreateLocation::class => [
            CreateLocationLis::class
        ],
        CreateMachine::class => [
            CreateMachineLis::class
        ],
        CreateMaintenance::class => [
            CreateMaintenanceLis::class
        ],
        CreateMaintenanceRequest::class => [
            CreateMaintenanceRequestLis::class
        ],
        CreateMaintenances::class => [
            CreateMaintenancesLis::class
        ],
        CreateManufacturing::class => [
            CreateManufacturingLis::class
        ],
        CreateMarkAttendance::class => [
            CreateMarkAttendanceLis::class
        ],
        CreateMarketingPlan::class => [
            CreateMarketingPlanLis::class
        ],
        CreateMcKinseyModel::class => [
            CreateMcKinseyModelLis::class
        ],
        CreateMeasurement::class => [
            CreateMeasurementLis::class
        ],
        CreateMedicalAppoinment::class => [
            CreateMedicalAppoinmentLis::class
        ],
        CreateMedicalRecords::class => [
            CreateMedicalRecordsLis::class
        ],
        CreateMeeingHubMeeting::class => [
            CreateMeeingHubMeetingLis::class
        ],
        CreateMeeingHubMeetingType::class => [
            CreateMeeingHubMeetingTypeLis::class
        ],
        CreateMeeting::class => [
            CreateMeetingLis::class
        ],
        CreateMembershipPlan::class => [
            CreateMembershipPlanLis::class
        ],
        CreateMenuSelection::class => [
            CreateMenuSelectionLis::class
        ],
        CreateMilestone::class => [
            CreateMilestoneLis::class
        ],
        CreateMilkInventory::class => [
            CreateMilkInventoryLis::class
        ],
        CreateMilkProduct::class => [
            CreateMilkProductLis::class
        ],
        CreateMonthlyPayslip::class => [
            CreateMonthlyPayslipLis::class
        ],
        CreateMovieCast::class => [
            CreateMovieCastLis::class
        ],
        CreateMovieShow::class => [
            CreateMovieShowLis::class
        ],
        CreateMusicClass::class => [
            CreateMusicClassLis::class
        ],
        CreateMusicInstrument::class => [
            CreateMusicInstrumentLis::class
        ],
        CreateMusicStudent::class => [
            CreateMusicStudentLis::class
        ],
        CreateMusicTeacher::class => [
            CreateMusicTeacherLis::class
        ],
        CreateNewspaperAds::class => [
            CreateNewspaperAdsLis::class
        ],
        CreateNewspaperAgent::class => [
            CreateNewspaperAgentLis::class
        ],
        CreateNewspaperDistributions::class => [
            CreateNewspaperDistributionsLis::class
        ],
        CreateNewspaperInvoice::class => [
            CreateNewspaperInvoiceLis::class
        ],
        CreateNewspaperJournalistInfo::class => [
            CreateNewspaperJournalistInfoLis::class
        ],
        CreateNewspaperJournalist::class => [
            CreateNewspaperJournalistLis::class
        ],
        CreateNewspaper::class => [
            CreateNewspaperLis::class
        ],
        CreateNotes::class => [
            CreateNotesLis::class
        ],
        CreateOpportunities::class => [
            CreateOpportunitiesLis::class
        ],
        CreateOtherPayment::class => [
            CreateOtherPaymentLis::class
        ],
        CreateOvertime::class => [
            CreateOvertimeLis::class
        ],
        CreatePESTAnalysisModel::class => [
            CreatePESTAnalysisModelLis::class
        ],
        CreatePESTELAnalysisModel::class => [
            CreatePESTELAnalysisModelLis::class
        ],
        CreatePackaging::class => [
            CreatePackagingLis::class
        ],
        CreatePageOption::class => [
            CreatePageOptionLis::class
        ],
        CreateParent::class => [
            CreateParentLis::class
        ],
        CreateParking::class => [
            CreateParkingLis::class
        ],
        CreateParkingPayment::class => [
            CreateParkingPaymentLis::class
        ],
        CreatePart::class => [
            CreatePartLis::class
        ],
        CreatePatientCard::class => [
            CreatePatientCardLis::class
        ],
        CreatePatient::class => [
            CreatePatientLis::class
        ],
        CreatePaymentCarPurchase::class => [
            CreatePaymentCarPurchaseLis::class
        ],
        CreatePaymentCarSale::class => [
            CreatePaymentCarSaleLis::class
        ],
        CreatePaymentDefectsAndRepairs::class => [
            CreatePaymentDefectsAndRepairsLis::class
        ],
        CreatePaymentDiagnosis::class => [
            CreatePaymentDiagnosisLis::class
        ],
        CreatePaymentInvoice::class => [
            CreatePaymentInvoiceLis::class
        ],
        CreatePayment::class => [
            CreatePaymentLis::class
        ],
        CreatePaymentMonthlyPayslip::class => [
            CreatePaymentMonthlyPayslipLis::class
        ],
        CreatePlanningChallenge::class => [
            CreatePlanningChallengeLis::class
        ],
        CreatePms::class => [
            CreatePmsLis::class
        ],
        CreatePortersFiveForcesMode::class => [
            CreatePortersFiveForcesModeLis::class
        ],
        CreatePortfolio::class => [
            CreatePortfolioLis::class
        ],
        CreatePreDefinedKit::class => [
            CreatePreDefinedKitLis::class
        ],
        CreateProduct::class => [
            CreateProductLis::class
        ],
        CreateProject::class => [
            CreateProjectLis::class
        ],
        CreatePromotion::class => [
            CreatePromotionLis::class
        ],
        CreatePropertyInvoicePayment::class => [
            CreatePropertyInvoicePaymentLis::class
        ],
        CreateProperty::class => [
            CreatePropertyLis::class
        ],
        CreatePropertyUnit::class => [
            CreatePropertyUnitLis::class
        ],
        CreateProposal::class => [
            CreateProposalLis::class
        ],
        CreatePublicTicket::class => [
            CreatePublicTicketLis::class
        ],
        CreatePurchase::class => [
            CreatePurchaseLis::class
        ],
        CreatePurchaseOrder::class => [
            CreatePurchaseOrderLis::class
        ],
        CreateQuestion::class => [
            CreateQuestionLis::class
        ],
        CreateQuotation::class => [
            CreateQuotationLis::class
        ],
        CreateQuote::class => [
            CreateQuoteLis::class
        ],
        CreateRating::class => [
            CreateRatingLis::class
        ],
        CreateRawMaterial::class => [
            CreateRawMaterialLis::class
        ],
        CreateReminder::class => [
            CreateReminderLis::class
        ],
        CreateRental::class => [
            CreateRentalLis::class
        ],
        CreateRepairOrderRequest::class => [
            CreateRepairOrderRequestLis::class
        ],
        CreateRepairPart::class => [
            CreateRepairPartLis::class
        ],
        CreateRepairRequest::class => [
            CreateRepairRequestLis::class
        ],
        CreateRequests::class => [
            CreateRequestsLis::class
        ],
        CreateResignation::class => [
            CreateResignationLis::class
        ],
        CreateRestaurantCustomer::class => [
            CreateRestaurantCustomerLis::class
        ],
        CreateRetainer::class => [
            CreateRetainerLis::class
        ],
        CreateRoadmapIdeas::class => [
            CreateRoadmapIdeasLis::class
        ],
        CreateRoadmap::class => [
            CreateRoadmapLis::class
        ],
        CreateRoomBooking::class => [
            CreateRoomBookingLis::class
        ],
        CreateRoomFacility::class => [
            CreateRoomFacilityLis::class
        ],
        CreateRoomFeature::class => [
            CreateRoomFeatureLis::class
        ],
        CreateRoom::class => [
            CreateRoomLis::class
        ],
        CreateRota::class => [
            CreateRotaLis::class
        ],
        CreateSWOTAnalysismodel::class => [
            CreateSWOTAnalysismodelLis::class
        ],
        CreateSaleOrder::class => [
            CreateSaleOrderLis::class
        ],
        CreateSalesAccount::class => [
            CreateSalesAccountLis::class
        ],
        CreateSalesDocument::class => [
            CreateSalesDocumentLis::class
        ],
        CreateSalesInvoice::class => [
            CreateSalesInvoiceLis::class
        ],
        CreateSalesOrderConvert::class => [
            CreateSalesOrderConvertLis::class
        ],
        CreateSalesOrder::class => [
            CreateSalesOrderLis::class
        ],
        CreateSaturationDeduction::class => [
            CreateSaturationDeductionLis::class
        ],
        CreateSchoolHomework::class => [
            CreateSchoolHomeworkLis::class
        ],
        CreateSchoolParent::class => [
            CreateSchoolParentLis::class
        ],
        CreateSchoolStudent::class => [
            CreateSchoolStudentLis::class
        ],
        CreateSeatingTemplate::class => [
            CreateSeatingTemplateLis::class
        ],
        CreateService::class => [
            CreateServiceLis::class
        ],
        CreateSideMenuBuilder::class => [
            CreateSideMenuBuilderLis::class
        ],
        CreateSpreadsheet::class => [
            CreateSpreadsheetLis::class
        ],
        CreateSubject::class => [
            CreateSubjectLis::class
        ],
        CreateSupplier::class => [
            CreateSupplierLis::class
        ],
        CreateTask::class => [
            CreateTaskLis::class
        ],
        CreateTemplate::class => [
            CreateTemplateLis::class
        ],
        CreateTenant::class => [
            CreateTenantLis::class
        ],
        CreateTermination::class => [
            CreateTerminationLis::class
        ],
        CreateTicket::class => [
            CreateTicketLis::class
        ],
        CreateTimesheet::class => [
            CreateTimesheetLis::class
        ],
        CreateTimetable::class => [
            CreateTimetableLis::class
        ],
        CreateToDo::class => [
            CreateToDoLis::class
        ],
        CreateTourBooking::class => [
            CreateTourBookingLis::class
        ],
        CreateTourInquiry::class => [
            CreateTourInquiryLis::class
        ],
        CreateTour::class => [
            CreateTourLis::class
        ],
        CreateTrainer::class => [
            CreateTrainerLis::class
        ],
        CreateTraining::class => [
            CreateTrainingLis::class
        ],
        CreateTransfer::class => [
            CreateTransferLis::class
        ],
        CreateTrip::class => [
            CreateTripLis::class
        ],
        CreateTvStudioBlog::class => [
            CreateTvStudioBlogLis::class
        ],
        CreateTvStudioContent::class => [
            CreateTvStudioContentLis::class
        ],
        CreateTvStudioContentOrder::class => [
            CreateTvStudioContentOrderLis::class
        ],
        CreateTvStudioCoupon::class => [
            CreateTvStudioCouponLis::class
        ],
        CreateTvStudioCustomPage::class => [
            CreateTvStudioCustomPageLis::class
        ],
        CreateTvStudioCustomer::class => [
            CreateTvStudioCustomerLis::class
        ],
        CreateTvStudioPlaylist::class => [
            CreateTvStudioPlaylistLis::class
        ],
        CreateUser::class => [
            CreateUserLis::class
        ],
        CreateVehicleBooking::class => [
            CreateVehicleBookingLis::class
        ],
        CreateVehicle::class => [
            CreateVehicleLis::class
        ],
        CreateVehicleRoute::class => [
            CreateVehicleRouteLis::class
        ],
        CreateVendor::class => [
            CreateVendorLis::class
        ],
        CreateVideoHubComment::class => [
            CreateVideoHubCommentLis::class
        ],
        CreateVideoHubVideo::class => [
            CreateVideoHubVideoLis::class
        ],
        CreateVisitReason::class => [
            CreateVisitReasonLis::class
        ],
        CreateVisitorLog::class => [
            CreateVisitorLogLis::class
        ],
        CreateWarehouse::class => [
            CreateWarehouseLis::class
        ],
        CreateWarning::class => [
            CreateWarningLis::class
        ],
        CreateWeight::class => [
            CreateWeightLis::class
        ],
        CreateWorkflow::class => [
            CreateWorkflowLis::class
        ],
        CreateWorkorder::class => [
            CreateWorkorderLis::class
        ],
        CreateWorkoutPlan::class => [
            CreateWorkoutPlanLis::class
        ],
        CreateWorkrequest::class => [
            CreateWorkrequestLis::class
        ],
        CreateZoommeeting::class => [
            CreateZoommeetingLis::class
        ],
        CretaeRepairInvoice::class => [
            CretaeRepairInvoiceLis::class
        ],
        DealAddCall::class => [
            DealAddCallLis::class
        ],
        DealAddClient::class => [
            DealAddClientLis::class
        ],
        DealAddDiscussion::class => [
            DealAddDiscussionLis::class
        ],
        DealAddEmail::class => [
            DealAddEmailLis::class
        ],
        DealAddNote::class => [
            DealAddNoteLis::class
        ],
        DealAddProduct::class => [
            DealAddProductLis::class
        ],
        DealAddUser::class => [
            DealAddUserLis::class
        ],
        DealCallUpdate::class => [
            DealCallUpdateLis::class
        ],
        DealMoved::class => [
            DealMovedLis::class
        ],
        DealSourceUpdate::class => [
            DealSourceUpdateLis::class
        ],
        DealUploadFile::class => [
            DealUploadFileLis::class
        ],
        DuplicateBill::class => [
            DuplicateBillLis::class
        ],
        DuplicateBookingsPackage::class => [
            DuplicateBookingsPackageLis::class
        ],
        DuplicateInvoice::class => [
            DuplicateInvoiceLis::class
        ],
        DuplicateProposal::class => [
            DuplicateProposalLis::class
        ],
        DuplicateRental::class => [
            DuplicateRentalLis::class
        ],
        FormBuilderConvertTo::class => [
            FormBuilderConvertToLis::class
        ],
        HospitalAppointmentStatus::class => [
            HospitalAppointmentStatusLis::class
        ],
        InquiryStatusChange::class => [
            InquiryStatusChangeLis::class
        ],
        JobApplicationArchive::class => [
            JobApplicationArchiveLis::class
        ],
        JobApplicationChangeOrder::class => [
            JobApplicationChangeOrderLis::class
        ],
        LaundryRequestCreate::class => [
            LaundryRequestCreateLis::class
        ],
        LaundryRequestUpdate::class => [
            LaundryRequestUpdateLis::class
        ],
        LeadAddCall::class => [
            LeadAddCallLis::class
        ],
        LeadAddDiscussion::class => [
            LeadAddDiscussionLis::class
        ],
        LeadAddEmail::class => [
            LeadAddEmailLis::class
        ],
        LeadAddNote::class => [
            LeadAddNoteLis::class
        ],
        LeadAddProduct::class => [
            LeadAddProductLis::class
        ],
        LeadAddUser::class => [
            LeadAddUserLis::class
        ],
        LeadConvertDeal::class => [
            LeadConvertDealLis::class
        ],
        LeadMoved::class => [
            LeadMovedLis::class
        ],
        LeadSourceUpdate::class => [
            LeadSourceUpdateLis::class
        ],
        LeadUpdateCall::class => [
            LeadUpdateCallLis::class
        ],
        LeadUploadFile::class => [
            LeadUploadFileLis::class
        ],
        LeaveStatus::class => [
            LeaveStatusLis::class
        ],
        LundaryRequestInvoiceCreate::class => [
            LundaryRequestInvoiceCreateLis::class
        ],
        Manualpaymentdatastore::class => [
            ManualpaymentdatastoreLis::class
        ],
        Manualpaymentdataupdate::class => [
            ManualpaymentdataupdateLis::class
        ],
        MedicineCreate::class => [
            MedicineCreateLis::class
        ],
        MedicineUpdate::class => [
            MedicineUpdateLis::class
        ],
        MobileServiceCreate::class => [
            MobileServiceCreateLis::class
        ],
        MobileServicePendingRequestAccept::class => [
            MobileServicePendingRequestAcceptLis::class
        ],
        MobileServicePendingRequestReject::class => [
            MobileServicePendingRequestRejectLis::class
        ],
        MobileServiceUpdate::class => [
            MobileServiceUpdateLis::class
        ],
        PaymentReminderInvoice::class => [
            PaymentReminderInvoiceLis::class
        ],
        PayslipSend::class => [
            PayslipSendLis::class
        ],
        PharmacyBillCreate::class => [
            PharmacyBillCreateLis::class
        ],
        PharmacyBillUpdate::class => [
            PharmacyBillUpdateLis::class
        ],
        PharmacyInvoiceCreate::class => [
            PharmacyInvoiceCreateLis::class
        ],
        PharmacyInvoicePaymentCreate::class => [
            PharmacyInvoicePaymentCreateLis::class
        ],
        PharmacyInvoiceUpdate::class => [
            PharmacyInvoiceUpdateLis::class
        ],
        PortfolioCategoryCreate::class => [
            PortfolioCategoryCreateLis::class
        ],
        ProjectInviteUser::class => [
            ProjectInviteUserLis::class
        ],
        ProjectShareToClient::class => [
            ProjectShareToClientLis::class
        ],
        ProjectUploadFiles::class => [
            ProjectUploadFilesLis::class
        ],
        QuoteDuplicate::class => [
            QuoteDuplicateLis::class
        ],
        ResentBill::class => [
            ResentBillLis::class
        ],
        ResentInvoice::class => [
            ResentInvoiceLis::class
        ],
        ResentProposal::class => [
            ResentProposalLis::class
        ],
        ResentPurchase::class => [
            ResentPurchaseLis::class
        ],
        ResentRetainer::class => [
            ResentRetainerLis::class
        ],
        RetainerConvertToInvoice::class => [
            RetainerConvertToInvoiceLis::class
        ],
        RetainerDuplicate::class => [
            RetainerDuplicateLis::class
        ],
        SalesAgentCreate::class => [
            SalesAgentCreateLis::class
        ],
        SalesAgentProgramCreate::class => [
            SalesAgentProgramCreateLis::class
        ],
        SalesAgentProgramUpdate::class => [
            SalesAgentProgramUpdateLis::class
        ],
        SalesAgentUpdate::class => [
            SalesAgentUpdateLis::class
        ],
        SalesInvoiceItemDuplicate::class => [
            SalesInvoiceItemDuplicateLis::class
        ],
        SalesOrderDuplicate::class => [
            SalesOrderDuplicateLis::class
        ],
        SendMailContract::class => [
            SendMailContractLis::class
        ],
        SendRotasViaEmail::class => [
            SendRotasViaEmailLis::class
        ],
        SentBill::class => [
            SentBillLis::class
        ],
        SentInvoice::class => [
            SentInvoiceLis::class
        ],
        SentProposal::class => [
            SentProposalLis::class
        ],
        SentPurchase::class => [
            SentPurchaseLis::class
        ],
        SentRetainer::class => [
            SentRetainerLis::class
        ],
        StatusChangeDealTask::class => [
            StatusChangeDealTaskLis::class
        ],
        StatusChangeProposal::class => [
            StatusChangeProposalLis::class
        ],
        StatusChangeRoomBooking::class => [
            StatusChangeRoomBookingLis::class
        ],
        UpdateAccessories::class => [
            UpdateAccessoriesLis::class
        ],
        UpdateAdmission::class => [
            UpdateAdmissionLis::class
        ],
        UpdateAdvocate::class => [
            UpdateAdvocateLis::class
        ],
        UpdateAgricultureActivities::class => [
            UpdateAgricultureActivitiesLis::class
        ],
        UpdateAgricultureCanal::class => [
            UpdateAgricultureCanalLis::class
        ],
        UpdateAgricultureClaimType::class => [
            UpdateAgricultureClaimTypeLis::class
        ],
        UpdateAgricultureCrop::class => [
            UpdateAgricultureCropLis::class
        ],
        UpdateAgricultureCultivation::class => [
            UpdateAgricultureCultivationLis::class
        ],
        UpdateAgricultureCycles::class => [
            UpdateAgricultureCyclesLis::class
        ],
        UpdateAgricultureDepartment::class => [
            UpdateAgricultureDepartmentLis::class
        ],
        UpdateAgricultureEquipment::class => [
            UpdateAgricultureEquipmentLis::class
        ],
        UpdateAgricultureOffices::class => [
            UpdateAgricultureOfficesLis::class
        ],
        UpdateAgricultureProcess::class => [
            UpdateAgricultureProcessLis::class
        ],
        UpdateAgricultureSeason::class => [
            UpdateAgricultureSeasonLis::class
        ],
        UpdateAgricultureSeasonType::class => [
            UpdateAgricultureSeasonTypeLis::class
        ],
        UpdateAgricultureServiceProduct::class => [
            UpdateAgricultureServiceProductLis::class
        ],
        UpdateAgricultureServices::class => [
            UpdateAgricultureServicesLis::class
        ],
        UpdateAgricultureUser::class => [
            UpdateAgricultureUserLis::class
        ],
        UpdateAgriculturefleet::class => [
            UpdateAgriculturefleetLis::class
        ],
        UpdateAllowance::class => [
            UpdateAllowanceLis::class
        ],
        UpdateAnimal::class => [
            UpdateAnimalLis::class
        ],
        UpdateAnnouncement::class => [
            UpdateAnnouncementLis::class
        ],
        UpdateAppointment::class => [
            UpdateAppointmentLis::class
        ],
        UpdateAppraisal::class => [
            UpdateAppraisalLis::class
        ],
        UpdateArticle::class => [
            UpdateArticleLis::class
        ],
        UpdateAsset::class => [
            UpdateAssetLis::class
        ],
        UpdateAssets::class => [
            UpdateAssetsLis::class
        ],
        UpdateAudit::class => [
            UpdateAuditLis::class
        ],
        UpdateAvailability::class => [
            UpdateAvailabilityLis::class
        ],
        UpdateAward::class => [
            UpdateAwardLis::class
        ],
        UpdateBankAccount::class => [
            UpdateBankAccountLis::class
        ],
        UpdateBankTransfer::class => [
            UpdateBankTransferLis::class
        ],
        UpdateBeautyBooking::class => [
            UpdateBeautyBookingLis::class
        ],
        UpdateBeautyService::class => [
            UpdateBeautyServiceLis::class
        ],
        UpdateBill::class => [
            UpdateBillLis::class
        ],
        UpdateBillOfMaterial::class => [
            UpdateBillOfMaterialLis::class
        ],
        UpdateBlog::class => [
            UpdateBlogLis::class
        ],
        UpdateBook::class => [
            UpdateBookLis::class
        ],
        UpdateBookingCoupon::class => [
            UpdateBookingCouponLis::class
        ],
        UpdateBooking::class => [
            UpdateBookingLis::class
        ],
        UpdateBookingsAppointment::class => [
            UpdateBookingsAppointmentLis::class
        ],
        UpdateBookingsCustomer::class => [
            UpdateBookingsCustomerLis::class
        ],
        UpdateBookingsPackage::class => [
            UpdateBookingsPackageLis::class
        ],
        UpdateBookingsStaff::class => [
            UpdateBookingsStaffLis::class
        ],
        UpdateBreeding::class => [
            UpdateBreedingLis::class
        ],
        UpdateBug::class => [
            UpdateBugLis::class
        ],
        UpdateBugStage::class => [
            UpdateBugStageLis::class
        ],
        UpdateBulkAttendance::class => [
            UpdateBulkAttendanceLis::class
        ],
        UpdateBusiness::class => [
            UpdateBusinessLis::class
        ],
        UpdateBusinessModel::class => [
            UpdateBusinessModelLis::class
        ],
        UpdateBusinessPlan::class => [
            UpdateBusinessPlanLis::class
        ],
        UpdateBusinessProcessMapping::class => [
            UpdateBusinessProcessMappingLis::class
        ],
        UpdateCall::class => [
            UpdateCallLis::class
        ],
        UpdateCallList::class => [
            UpdateCallListLis::class
        ],
        UpdateCallhubAdavance::class => [
            UpdateCallhubAdavanceLis::class
        ],
        UpdateCarPurchase::class => [
            UpdateCarPurchaseLis::class
        ],
        UpdateCarSale::class => [
            UpdateCarSaleLis::class
        ],
        UpdateCaseInitiator::class => [
            UpdateCaseInitiatorLis::class
        ],
        UpdateCase::class => [
            UpdateCaseLis::class
        ],
        UpdateCateringCustomer::class => [
            UpdateCateringCustomerLis::class
        ],
        UpdateChallenge::class => [
            UpdateChallengeLis::class
        ],
        UpdateCharter::class => [
            UpdateCharterLis::class
        ],
        UpdateChildAttendance::class => [
            UpdateChildAttendanceLis::class
        ],
        UpdateChildBulkAttendance::class => [
            UpdateChildBulkAttendanceLis::class
        ],
        UpdateChild::class => [
            UpdateChildLis::class
        ],
        UpdateClassroom::class => [
            UpdateClassroomLis::class
        ],
        UpdateCleaningBooking::class => [
            UpdateCleaningBookingLis::class
        ],
        UpdateCleaningTeam::class => [
            UpdateCleaningTeamLis::class
        ],
        UpdateCollectionCenter::class => [
            UpdateCollectionCenterLis::class
        ],
        UpdateCommission::class => [
            UpdateCommissionLis::class
        ],
        UpdateCommissionPlan::class => [
            UpdateCommissionPlanLis::class
        ],
        UpdateCommonCase::class => [
            UpdateCommonCaseLis::class
        ],
        UpdateCompanyPolicy::class => [
            UpdateCompanyPolicyLis::class
        ],
        UpdateComplaint::class => [
            UpdateComplaintLis::class
        ],
        UpdateConsignment::class => [
            UpdateConsignmentLis::class
        ],
        UpdateConsignmentProduct::class => [
            UpdateConsignmentProductLis::class
        ],
        UpdateConsumables::class => [
            UpdateConsumablesLis::class
        ],
        UpdateContact::class => [
            UpdateContactLis::class
        ],
        UpdateCourseCoupon::class => [
            UpdateCourseCouponLis::class
        ],
        UpdateCourse::class => [
            UpdateCourseLis::class
        ],
        UpdateCourt::class => [
            UpdateCourtLis::class
        ],
        UpdateCreativity::class => [
            UpdateCreativityLis::class
        ],
        UpdateCustomField::class => [
            UpdateCustomFieldLis::class
        ],
        UpdateCustomPage::class => [
            UpdateCustomPageLis::class
        ],
        UpdateCustomQuestion::class => [
            UpdateCustomQuestionLis::class
        ],
        UpdateCustomer::class => [
            UpdateCustomerLis::class
        ],
        UpdateDailyMilkSheet::class => [
            UpdateDailyMilkSheetLis::class
        ],
        UpdateDeal::class => [
            UpdateDealLis::class
        ],
        UpdateDealTask::class => [
            UpdateDealTaskLis::class
        ],
        UpdateDealershipProduct::class => [
            UpdateDealershipProductLis::class
        ],
        UpdateDefectsAndRepairs::class => [
            UpdateDefectsAndRepairsLis::class
        ],
        UpdateDiagnosis::class => [
            UpdateDiagnosisLis::class
        ],
        UpdateDiningTable::class => [
            UpdateDiningTableLis::class
        ],
        UpdateDivision::class => [
            UpdateDivisionLis::class
        ],
        UpdateDoctor::class => [
            UpdateDoctorLis::class
        ],
        UpdateDocument::class => [
            UpdateDocumentLis::class
        ],
        UpdateDocumentType::class => [
            UpdateDocumentTypeLis::class
        ],
        UpdateDriver::class => [
            UpdateDriverLis::class
        ],
        UpdateDrivingClass::class => [
            UpdateDrivingClassLis::class
        ],
        UpdateDrivingInvoice::class => [
            UpdateDrivingInvoiceLis::class
        ],
        UpdateDrivingStudent::class => [
            UpdateDrivingStudentLis::class
        ],
        UpdateDrivingVehicle::class => [
            UpdateDrivingVehicleLis::class
        ],
        UpdateEmployee::class => [
            UpdateEmployeeLis::class
        ],
        UpdateEmployeeSalary::class => [
            UpdateEmployeeSalaryLis::class
        ],
        UpdateEventDetail::class => [
            UpdateEventDetailLis::class
        ],
        UpdateEvent::class => [
            UpdateEventLis::class
        ],
        UpdateExpense::class => [
            UpdateExpenseLis::class
        ],
        UpdateFee::class => [
            UpdateFeeLis::class
        ],
        UpdateFeeReciept::class => [
            UpdateFeeRecieptLis::class
        ],
        UpdateFeeRecieve::class => [
            UpdateFeeRecieveLis::class
        ],
        UpdateFile::class => [
            UpdateFileLis::class
        ],
        UpdateFinacialGoal::class => [
            UpdateFinacialGoalLis::class
        ],
        UpdateFixComponent::class => [
            UpdateFixComponentLis::class
        ],
        UpdateFleetCustomer::class => [
            UpdateFleetCustomerLis::class
        ],
        UpdateFormField::class => [
            UpdateFormFieldLis::class
        ],
        UpdateForm::class => [
            UpdateFormLis::class
        ],
        UpdateFreightBookingRequest::class => [
            UpdateFreightBookingRequestLis::class
        ],
        UpdateFreightCustomer::class => [
            UpdateFreightCustomerLis::class
        ],
        UpdateFuel::class => [
            UpdateFuelLis::class
        ],
        UpdateGarageVehicle::class => [
            UpdateGarageVehicleLis::class
        ],
        UpdateGoalTracking::class => [
            UpdateGoalTrackingLis::class
        ],
        UpdateGymMember::class => [
            UpdateGymMemberLis::class
        ],
        UpdateGymTrainer::class => [
            UpdateGymTrainerLis::class
        ],
        UpdateHealth::class => [
            UpdateHealthLis::class
        ],
        UpdateHighCourt::class => [
            UpdateHighCourtLis::class
        ],
        UpdateHolidays::class => [
            UpdateHolidaysLis::class
        ],
        UpdateHospitalAppointment::class => [
            UpdateHospitalAppointmentLis::class
        ],
        UpdateHospitalBed::class => [
            UpdateHospitalBedLis::class
        ],
        UpdateHospitalMedicine::class => [
            UpdateHospitalMedicineLis::class
        ],
        UpdateHotelCustomer::class => [
            UpdateHotelCustomerLis::class
        ],
        UpdateHotelService::class => [
            UpdateHotelServiceLis::class
        ],
        UpdateIndicator::class => [
            UpdateIndicatorLis::class
        ],
        UpdateInquiry::class => [
            UpdateInquiryLis::class
        ],
        UpdateInspectionList::class => [
            UpdateInspectionListLis::class
        ],
        UpdateInspectionRequest::class => [
            UpdateInspectionRequestLis::class
        ],
        UpdateInspectionVehicle::class => [
            UpdateInspectionVehicleLis::class
        ],
        UpdateInsurance::class => [
            UpdateInsuranceLis::class
        ],
        UpdateInterviewSchedule::class => [
            UpdateInterviewScheduleLis::class
        ],
        UpdateInvoice::class => [
            UpdateInvoiceLis::class
        ],
        UpdateJobBoard::class => [
            UpdateJobBoardLis::class
        ],
        UpdateJobCandidate::class => [
            UpdateJobCandidateLis::class
        ],
        UpdateJob::class => [
            UpdateJobLis::class
        ],
        UpdateJournalAccount::class => [
            UpdateJournalAccountLis::class
        ],
        UpdateLabPatient::class => [
            UpdateLabPatientLis::class
        ],
        UpdateLabRequest::class => [
            UpdateLabRequestLis::class
        ],
        UpdateLead::class => [
            UpdateLeadLis::class
        ],
        UpdateLeave::class => [
            UpdateLeaveLis::class
        ],
        UpdateLicence::class => [
            UpdateLicenceLis::class
        ],
        UpdateLoan::class => [
            UpdateLoanLis::class
        ],
        UpdateLocation::class => [
            UpdateLocationLis::class
        ],
        UpdateMachine::class => [
            UpdateMachineLis::class
        ],
        UpdateMaintenance::class => [
            UpdateMaintenanceLis::class
        ],
        UpdateMaintenanceRequest::class => [
            UpdateMaintenanceRequestLis::class
        ],
        UpdateMaintenances::class => [
            UpdateMaintenancesLis::class
        ],
        UpdateManufacturing::class => [
            UpdateManufacturingLis::class
        ],
        UpdateMarkAttendance::class => [
            UpdateMarkAttendanceLis::class
        ],
        UpdateMarketingPlan::class => [
            UpdateMarketingPlanLis::class
        ],
        UpdateMcKinseyModel::class => [
            UpdateMcKinseyModelLis::class
        ],
        UpdateMeasurement::class => [
            UpdateMeasurementLis::class
        ],
        UpdateMedicalAppoinment::class => [
            UpdateMedicalAppoinmentLis::class
        ],
        UpdateMedicalRecords::class => [
            UpdateMedicalRecordsLis::class
        ],
        UpdateMeeingHubMeeting::class => [
            UpdateMeeingHubMeetingLis::class
        ],
        UpdateMeeingHubMeetingType::class => [
            UpdateMeeingHubMeetingTypeLis::class
        ],
        UpdateMeeting::class => [
            UpdateMeetingLis::class
        ],
        UpdateMembershipPlan::class => [
            UpdateMembershipPlanLis::class
        ],
        UpdateMenuSelection::class => [
            UpdateMenuSelectionLis::class
        ],
        UpdateMilestone::class => [
            UpdateMilestoneLis::class
        ],
        UpdateMilkInventory::class => [
            UpdateMilkInventoryLis::class
        ],
        UpdateMilkProduct::class => [
            UpdateMilkProductLis::class
        ],
        UpdateMonthlyPayslip::class => [
            UpdateMonthlyPayslipLis::class
        ],
        UpdateMovieCast::class => [
            UpdateMovieCastLis::class
        ],
        UpdateMovieShow::class => [
            UpdateMovieShowLis::class
        ],
        UpdateMusicClass::class => [
            UpdateMusicClassLis::class
        ],
        UpdateMusicInstrument::class => [
            UpdateMusicInstrumentLis::class
        ],
        UpdateMusicStudent::class => [
            UpdateMusicStudentLis::class
        ],
        UpdateMusicTeacher::class => [
            UpdateMusicTeacherLis::class
        ],
        UpdateNewspaperAds::class => [
            UpdateNewspaperAdsLis::class
        ],
        UpdateNewspaperAgent::class => [
            UpdateNewspaperAgentLis::class
        ],
        UpdateNewspaperDistributions::class => [
            UpdateNewspaperDistributionsLis::class
        ],
        UpdateNewspaperInvoice::class => [
            UpdateNewspaperInvoiceLis::class
        ],
        UpdateNewspaperJournalistInfo::class => [
            UpdateNewspaperJournalistInfoLis::class
        ],
        UpdateNewspaperJournalist::class => [
            UpdateNewspaperJournalistLis::class
        ],
        UpdateNewspaper::class => [
            UpdateNewspaperLis::class
        ],
        UpdateNotes::class => [
            UpdateNotesLis::class
        ],
        UpdateOpportunities::class => [
            UpdateOpportunitiesLis::class
        ],
        UpdateOtherPayment::class => [
            UpdateOtherPaymentLis::class
        ],
        UpdateOvertime::class => [
            UpdateOvertimeLis::class
        ],
        UpdatePESTAnalysisModel::class => [
            UpdatePESTAnalysisModelLis::class
        ],
        UpdatePESTELAnalysisModel::class => [
            UpdatePESTELAnalysisModelLis::class
        ],
        UpdatePackaging::class => [
            UpdatePackagingLis::class
        ],
        UpdatePageOption::class => [
            UpdatePageOptionLis::class
        ],
        UpdateParent::class => [
            UpdateParentLis::class
        ],
        UpdatePatientCard::class => [
            UpdatePatientCardLis::class
        ],
        UpdatePatient::class => [
            UpdatePatientLis::class
        ],
        UpdatePayment::class => [
            UpdatePaymentLis::class
        ],
        UpdatePlanningChallenge::class => [
            UpdatePlanningChallengeLis::class
        ],
        UpdatePortersFiveForcesMode::class => [
            UpdatePortersFiveForcesModeLis::class
        ],
        UpdatePortfolioCategory::class => [
            UpdatePortfolioCategoryLis::class
        ],
        UpdatePortfolio::class => [
            UpdatePortfolioLis::class
        ],
        UpdatePreDefinedKit::class => [
            UpdatePreDefinedKitLis::class
        ],
        UpdateProduct::class => [
            UpdateProductLis::class
        ],
        Updateproject::class => [
            UpdateProjectLis::class
        ],
        UpdatePromotion::class => [
            UpdatePromotionLis::class
        ],
        UpdateProperty::class => [
            UpdatePropertyLis::class
        ],
        UpdatePropertyUnit::class => [
            UpdatePropertyUnitLis::class
        ],
        UpdateProposal::class => [
            UpdateProposalLis::class
        ],
        UpdatePurchase::class => [
            UpdatePurchaseLis::class
        ],
        UpdatePurchaseOrder::class => [
            UpdatePurchaseOrderLis::class
        ],
        UpdateQuestion::class => [
            UpdateQuestionLis::class
        ],
        UpdateQuotation::class => [
            UpdateQuotationLis::class
        ],
        UpdateQuote::class => [
            UpdateQuoteLis::class
        ],
        UpdateRawMaterial::class => [
            UpdateRawMaterialLis::class
        ],
        UpdateReminder::class => [
            UpdateReminderLis::class
        ],
        UpdateRental::class => [
            UpdateRentalLis::class
        ],
        UpdateRepairOrderRequest::class => [
            UpdateRepairOrderRequestLis::class
        ],
        UpdateRepairPart::class => [
            UpdateRepairPartLis::class
        ],
        UpdateRepairRequest::class => [
            UpdateRepairRequestLis::class
        ],
        UpdateRequests::class => [
            UpdateRequestsLis::class
        ],
        UpdateResignation::class => [
            UpdateResignationLis::class
        ],
        UpdateRestaurantCustomer::class => [
            UpdateRestaurantCustomerLis::class
        ],
        UpdateRetainer::class => [
            UpdateRetainerLis::class
        ],
        UpdateRevenue::class => [
            UpdateRevenueLis::class
        ],
        UpdateRoadmapIdeas::class => [
            UpdateRoadmapIdeasLis::class
        ],
        UpdateRoadmap::class => [
            UpdateRoadmapLis::class
        ],
        UpdateRoomBooking::class => [
            UpdateRoomBookingLis::class
        ],
        UpdateRoomFacility::class => [
            UpdateRoomFacilityLis::class
        ],
        UpdateRoomFeature::class => [
            UpdateRoomFeatureLis::class
        ],
        UpdateRoom::class => [
            UpdateRoomLis::class
        ],
        UpdateRota::class => [
            UpdateRotaLis::class
        ],
        UpdateSWOTAnalysismodel::class => [
            UpdateSWOTAnalysismodelLis::class
        ],
        UpdateSaleOrder::class => [
            UpdateSaleOrderLis::class
        ],
        UpdateSalesAccount::class => [
            UpdateSalesAccountLis::class
        ],
        UpdateSalesDocument::class => [
            UpdateSalesDocumentLis::class
        ],
        UpdateSalesInvoice::class => [
            UpdateSalesInvoiceLis::class
        ],
        UpdateSalesOrder::class => [
            UpdateSalesOrderLis::class
        ],
        UpdateSaturationDeduction::class => [
            UpdateSaturationDeductionLis::class
        ],
        UpdateSchoolHomework::class => [
            UpdateSchoolHomeworkLis::class
        ],
        UpdateSchoolParent::class => [
            UpdateSchoolParentLis::class
        ],
        UpdateSchoolStudent::class => [
            UpdateSchoolStudentLis::class
        ],
        UpdateSeatingTemplate::class => [
            UpdateSeatingTemplateLis::class
        ],
        UpdateService::class => [
            UpdateServiceLis::class
        ],
        UpdateSideMenuBuilder::class => [
            UpdateSideMenuBuilderLis::class
        ],
        UpdateSpreadsheet::class => [
            UpdateSpreadsheetLis::class
        ],
        UpdateSubject::class => [
            UpdateSubjectLis::class
        ],
        UpdateTask::class => [
            UpdateTaskLis::class
        ],
        UpdateTaskStage::class => [
            UpdateTaskStageLis::class
        ],
        UpdateTemplate::class => [
            UpdateTemplateLis::class
        ],
        UpdateTenant::class => [
            UpdateTenantLis::class
        ],
        UpdateTermination::class => [
            UpdateTerminationLis::class
        ],
        UpdateTicket::class => [
            UpdateTicketLis::class
        ],
        UpdateTimesheet::class => [
            UpdateTimesheetLis::class
        ],
        UpdateTimetable::class => [
            UpdateTimetableLis::class
        ],
        UpdateToDo::class => [
            UpdateToDoLis::class
        ],
        UpdateTourInquiry::class => [
            UpdateTourInquiryLis::class
        ],
        UpdateTour::class => [
            UpdateTourLis::class
        ],
        UpdateTrainer::class => [
            UpdateTrainerLis::class
        ],
        UpdateTraining::class => [
            UpdateTrainingLis::class
        ],
        UpdateTransfer::class => [
            UpdateTransferLis::class
        ],
        UpdateTrip::class => [
            UpdateTripLis::class
        ],
        UpdateTvStudioBlog::class => [
            UpdateTvStudioBlogLis::class
        ],
        UpdateTvStudioContent::class => [
            UpdateTvStudioContentLis::class
        ],
        UpdateTvStudioCoupon::class => [
            UpdateTvStudioCouponLis::class
        ],
        UpdateTvStudioCustomPage::class => [
            UpdateTvStudioCustomPageLis::class
        ],
        UpdateTvStudioCustomer::class => [
            UpdateTvStudioCustomerLis::class
        ],
        UpdateTvStudioPlaylist::class => [
            UpdateTvStudioPlaylistLis::class
        ],
        UpdateUser::class => [
            UpdateUserLis::class
        ],
        UpdateVehicle::class => [
            UpdateVehicleLis::class
        ],
        UpdateVehicleRoute::class => [
            UpdateVehicleRouteLis::class
        ],
        UpdateVendor::class => [
            UpdateVendorLis::class
        ],
        UpdateVideoHubVideo::class => [
            UpdateVideoHubVideoLis::class
        ],
        UpdateVisitReason::class => [
            UpdateVisitReasonLis::class
        ],
        UpdateVisitorLog::class => [
            UpdateVisitorLogLis::class
        ],
        UpdateWarehouse::class => [
            UpdateWarehouseLis::class
        ],
        UpdateWarning::class => [
            UpdateWarningLis::class
        ],
        UpdateWeight::class => [
            UpdateWeightLis::class
        ],
        UpdateWorkSchedule::class => [
            UpdateWorkScheduleLis::class
        ],
        UpdateWorkflow::class => [
            UpdateWorkflowLis::class
        ],
        UpdateWorkingHours::class => [
            UpdateWorkingHoursLis::class
        ],
        UpdateWorkoutPlan::class => [
            UpdateWorkoutPlanLis::class
        ],
        Updatecontract::class => [
            UpdatecontractLis::class
        ],
        VcardCreateAppointment::class => [
            VcardCreateAppointmentLis::class
        ],
        VcardCreateContact::class => [
            VcardCreateContactLis::class
        ],
        VcardUpdateAppointment::class => [
            VcardUpdateAppointmentLis::class
        ],
        VcardUpdateContact::class => [
            VcardUpdateContactLis::class
        ],
        ViewForm::class => [
            ViewFormLis::class
        ],
        WasteCollectionRequestCreate::class => [
            WasteCollectionRequestCreateLis::class
        ],
        WasteCollectionRequestUpdate::class => [
            WasteCollectionRequestUpdateLis::class
        ],
        WastecollectionConvertedToTrip::class => [
            WastecollectionConvertedToTripLis::class
        ],
        ConvertIntoLeadSetting::class => [
            ConvertIntoLeadSettingLis::class
        ],
        CreatePaymentBill::class => [
            CreatePaymentBillLis::class
        ],
        CreatePaymentPurchase::class => [
            CreatePaymentPurchaseLis::class
        ],
        CreatePaymentRetainer::class => [
            CreatePaymentRetainerLis::class
        ],
        CreateRevenue::class => [
            CreateRevenueLis::class
        ],
        ImageGenerat::class => [
            ImageGeneratLis::class
        ],
        UpdateCmmspos::class => [
            UpdateCmmsposLis::class
        ],
        UpdateComponent::class => [
            UpdateComponentLis::class
        ],
        UpdateHistory::class => [
            UpdateHistoryLis::class
        ],
        UpdatePart::class => [
            UpdatePartLis::class
        ],
        UpdatePms::class => [
            UpdatePmsLis::class
        ],
        UpdateStatus::class => [
            UpdateStatusLis::class
        ],
        UpdateSupplier::class => [
            UpdateSupplierLis::class
        ],
        UpdateWorkorder::class => [
            UpdateWorkorderLis::class
        ],

    // Invoice payment
        StripePaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        SSpayPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        PaytrPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        PaypalPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        CashfreePaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        ToyyibpayPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        RazorpayPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        PaystackPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        MolliePaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        MercadoPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        FlutterwavePaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        PaytmPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        PayfastPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        IyzipayPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        PaytabPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        CoingatePaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        SkrillPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        AamarPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        BenefitPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        YooKassaPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
        BankTransferPaymentStatus::class => [
            InvoicePaymentLis::class
        ],
    ];

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        return [
            __DIR__ . '/../Listeners',
        ];
    }
}
