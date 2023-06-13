<?php
/*
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * Generated by gapic-generator-php from the file
 * https://github.com/googleapis/googleapis/blob/master/google/devtools/cloudprofiler/v2/profiler.proto
 * Updates to the above are reflected here through a refresh process.
 */

namespace Google\Cloud\Profiler\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Profiler\V2\CreateOfflineProfileRequest;
use Google\Cloud\Profiler\V2\CreateProfileRequest;
use Google\Cloud\Profiler\V2\Deployment;
use Google\Cloud\Profiler\V2\Profile;
use Google\Cloud\Profiler\V2\UpdateProfileRequest;
use Google\Protobuf\FieldMask;

/**
 * Service Description: Manage the collection of continuous profiling data provided by profiling
 * agents running in the cloud or by an offline provider of profiling data.
 *
 * General guidelines:
 * * Profiles for a single deployment must be created in ascending time order.
 * * Profiles can be created in either online or offline mode, see below.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $profilerServiceClient = new ProfilerServiceClient();
 * try {
 *     $response = $profilerServiceClient->createOfflineProfile();
 * } finally {
 *     $profilerServiceClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To
 * assist with these names, this class includes a format method for each type of
 * name, and additionally a parseName method to extract the individual identifiers
 * contained within formatted names that are returned by the API.
 *
 * This service has a new (beta) implementation. See {@see
 * \Google\Cloud\Profiler\V2\Client\ProfilerServiceClient} to use the new surface.
 */
class ProfilerServiceGapicClient
{
    use GapicClientTrait;

    /** The name of the service. */
    const SERVICE_NAME = 'google.devtools.cloudprofiler.v2.ProfilerService';

    /** The default address of the service. */
    const SERVICE_ADDRESS = 'cloudprofiler.googleapis.com';

    /** The default port of the service. */
    const DEFAULT_SERVICE_PORT = 443;

    /** The name of the code generator, to be included in the agent header. */
    const CODEGEN_NAME = 'gapic';

    /** The default scopes required by the service. */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/cloud-platform',
        'https://www.googleapis.com/auth/monitoring',
        'https://www.googleapis.com/auth/monitoring.write',
    ];

    private static $profileNameTemplate;

    private static $projectNameTemplate;

    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS . ':' . self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__ . '/../resources/profiler_service_client_config.json',
            'descriptorsConfigPath' => __DIR__ . '/../resources/profiler_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__ . '/../resources/profiler_service_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__ . '/../resources/profiler_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getProfileNameTemplate()
    {
        if (self::$profileNameTemplate == null) {
            self::$profileNameTemplate = new PathTemplate('projects/{project}/profiles/{profile}');
        }

        return self::$profileNameTemplate;
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'profile' => self::getProfileNameTemplate(),
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent a profile
     * resource.
     *
     * @param string $project
     * @param string $profile
     *
     * @return string The formatted profile resource.
     */
    public static function profileName($project, $profile)
    {
        return self::getProfileNameTemplate()->render([
            'project' => $project,
            'profile' => $profile,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent a project
     * resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     */
    public static function projectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - profile: projects/{project}/profiles/{profile}
     * - project: projects/{project}
     *
     * The optional $template argument can be supplied to specify a particular pattern,
     * and must match one of the templates listed above. If no $template argument is
     * provided, or if the $template argument does not match one of the templates
     * listed, then parseName will check each of the supported templates, and return
     * the first match.
     *
     * @param string $formattedName The formatted name string
     * @param string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     */
    public static function parseName($formattedName, $template = null)
    {
        $templateMap = self::getPathTemplateMap();
        if ($template) {
            if (!isset($templateMap[$template])) {
                throw new ValidationException("Template name $template does not exist");
            }

            return $templateMap[$template]->match($formattedName);
        }

        foreach ($templateMap as $templateName => $pathTemplate) {
            try {
                return $pathTemplate->match($formattedName);
            } catch (ValidationException $ex) {
                // Swallow the exception to continue trying other path templates
            }
        }

        throw new ValidationException("Input did not match any known format. Input: $formattedName");
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *     Optional. Options for configuring the service API wrapper.
     *
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'cloudprofiler.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the
     *           client. For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()} .
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either
     *           a path to a JSON file, or a PHP array containing the decoded JSON data. By
     *           default this settings points to the default client config file, which is
     *           provided in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string
     *           `rest` or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already
     *           instantiated {@see \Google\ApiCore\Transport\TransportInterface} object. Note
     *           that when this object is provided, any settings in $transportConfig, and any
     *           $apiEndpoint setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...],
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     *     @type callable $clientCertSource
     *           A callable which returns the client cert as a string. This can be used to
     *           provide a certificate and private key to the transport layer for mTLS.
     * }
     *
     * @throws ValidationException
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    /**
     * CreateOfflineProfile creates a new profile resource in the offline mode.
     * The client provides the profile to create along with the profile bytes, the
     * server records it.
     *
     * Sample code:
     * ```
     * $profilerServiceClient = new ProfilerServiceClient();
     * try {
     *     $response = $profilerServiceClient->createOfflineProfile();
     * } finally {
     *     $profilerServiceClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *     Optional.
     *
     *     @type string $parent
     *           Parent project to create the profile in.
     *     @type Profile $profile
     *           Contents of the profile to create.
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Profiler\V2\Profile
     *
     * @throws ApiException if the remote call fails
     */
    public function createOfflineProfile(array $optionalArgs = [])
    {
        $request = new CreateOfflineProfileRequest();
        $requestParamHeaders = [];
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
            $requestParamHeaders['parent'] = $optionalArgs['parent'];
        }

        if (isset($optionalArgs['profile'])) {
            $request->setProfile($optionalArgs['profile']);
        }

        $requestParams = new RequestParamsHeaderDescriptor($requestParamHeaders);
        $optionalArgs['headers'] = isset($optionalArgs['headers']) ? array_merge($requestParams->getHeader(), $optionalArgs['headers']) : $requestParams->getHeader();
        return $this->startCall('CreateOfflineProfile', Profile::class, $optionalArgs, $request)->wait();
    }

    /**
     * CreateProfile creates a new profile resource in the online mode.
     *
     * The server ensures that the new profiles are created at a constant rate per
     * deployment, so the creation request may hang for some time until the next
     * profile session is available.
     *
     * The request may fail with ABORTED error if the creation is not available
     * within ~1m, the response will indicate the duration of the backoff the
     * client should take before attempting creating a profile again. The backoff
     * duration is returned in google.rpc.RetryInfo extension on the response
     * status. To a gRPC client, the extension will be return as a
     * binary-serialized proto in the trailing metadata item named
     * "google.rpc.retryinfo-bin".
     *
     *
     * Sample code:
     * ```
     * $profilerServiceClient = new ProfilerServiceClient();
     * try {
     *     $response = $profilerServiceClient->createProfile();
     * } finally {
     *     $profilerServiceClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *     Optional.
     *
     *     @type string $parent
     *           Parent project to create the profile in.
     *     @type Deployment $deployment
     *           Deployment details.
     *     @type int[] $profileType
     *           One or more profile types that the agent is capable of providing.
     *           For allowed values, use constants defined on {@see \Google\Cloud\Profiler\V2\ProfileType}
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Profiler\V2\Profile
     *
     * @throws ApiException if the remote call fails
     */
    public function createProfile(array $optionalArgs = [])
    {
        $request = new CreateProfileRequest();
        $requestParamHeaders = [];
        if (isset($optionalArgs['parent'])) {
            $request->setParent($optionalArgs['parent']);
            $requestParamHeaders['parent'] = $optionalArgs['parent'];
        }

        if (isset($optionalArgs['deployment'])) {
            $request->setDeployment($optionalArgs['deployment']);
        }

        if (isset($optionalArgs['profileType'])) {
            $request->setProfileType($optionalArgs['profileType']);
        }

        $requestParams = new RequestParamsHeaderDescriptor($requestParamHeaders);
        $optionalArgs['headers'] = isset($optionalArgs['headers']) ? array_merge($requestParams->getHeader(), $optionalArgs['headers']) : $requestParams->getHeader();
        return $this->startCall('CreateProfile', Profile::class, $optionalArgs, $request)->wait();
    }

    /**
     * UpdateProfile updates the profile bytes and labels on the profile resource
     * created in the online mode. Updating the bytes for profiles created in the
     * offline mode is currently not supported: the profile content must be
     * provided at the time of the profile creation.
     *
     * Sample code:
     * ```
     * $profilerServiceClient = new ProfilerServiceClient();
     * try {
     *     $response = $profilerServiceClient->updateProfile();
     * } finally {
     *     $profilerServiceClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *     Optional.
     *
     *     @type Profile $profile
     *           Profile to update.
     *     @type FieldMask $updateMask
     *           Field mask used to specify the fields to be overwritten. Currently only
     *           profile_bytes and labels fields are supported by UpdateProfile, so only
     *           those fields can be specified in the mask. When no mask is provided, all
     *           fields are overwritten.
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Profiler\V2\Profile
     *
     * @throws ApiException if the remote call fails
     */
    public function updateProfile(array $optionalArgs = [])
    {
        $request = new UpdateProfileRequest();
        $requestParamHeaders = [];
        if (isset($optionalArgs['profile'])) {
            $request->setProfile($optionalArgs['profile']);
        }

        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor($requestParamHeaders);
        $optionalArgs['headers'] = isset($optionalArgs['headers']) ? array_merge($requestParams->getHeader(), $optionalArgs['headers']) : $requestParams->getHeader();
        return $this->startCall('UpdateProfile', Profile::class, $optionalArgs, $request)->wait();
    }
}
